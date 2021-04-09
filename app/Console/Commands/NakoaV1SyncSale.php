<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Validator, Auth, Exception, Log;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;

use Lacunose\Sale\Models\Menu;
use Lacunose\Sale\Models\Promo;
use Lacunose\Sale\Models\Product;
use Lacunose\Sale\Models\OrderChecker;
use Lacunose\Sale\Models\Order as SaleOrder;
use Lacunose\Sale\Aggregates\MenuAggregateRoot;
use Lacunose\Sale\Aggregates\PromoAggregateRoot;
use Lacunose\Sale\Aggregates\CatalogAggregateRoot;
use Lacunose\Sale\Aggregates\TransactionAggregateRoot as SaleTransactionAggregateRoot;

use Lacunose\Finance\Models\Coa;
use Lacunose\Finance\Models\Book;
use Lacunose\Finance\Aggregates\CoaAggregateRoot;
use Lacunose\Finance\Aggregates\BookAggregateRoot;

class NakoaV1SyncSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nakoa:sync:sale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data penjualan dari nakoa versi 1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Auth::loginUsingId(2);

        $this->set_menu();

        $this->set_katalog();

        $this->set_voucher();

        $this->set_sale();
    }

    private function set_menu() {
        $menus  = DB::connection('nakoa1')->table('app_product_item')->get();
        $recs   = [];
        foreach ($menus as $menu) {
            $product= DB::connection('nakoa1')->table('sales_products')->where('id', $menu->product_id)->first();
            $item   = DB::connection('nakoa1')->table('wh_items')->where('id', $menu->item_id)->first();

            if($product && $item) {
                $all_row['code']    = $product->code,
                $all_row['name']    = $product->name,
                $all_row['station'] = $product->category,
                $all_row['cogs']    = 0,
                $all_row['item_code']   = $item->code,
                $all_row['item_name']   = $item->name,
                $all_row['amount']      = $menu->qty,
                $all_row['cost']        = 0,
                $all_row['is_synced']   = Str::is($item->category, 'Packaging') true : false,
                
                $recs   = $this->batch_menu($recs, $all_row); 
            }
        }

        //SIMPAN MENU
        foreach ($recs as $k => $input) {
            $prod   = Menu::where('code', $input['code'])->first();
            $id     = $prod ? $prod->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$prod){
                    $dt = MenuAggregateRoot::retrieve($id)->save($input, [])->publish(now())->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC MENU');
                Log::info($e);
            }
        }
    }

    private function set_katalog() {
        $items      = DB::connection('nakoa1')->table('sales_products')->get();
        $recs       = [];
        foreach ($items as $item) {
            $code   = explode('-', $item->code);
            if(isset($code)[1]) {
                $var    = explode(' R', $item->name);
                if(!isset($var[1])) {
                    $var= explode(' L', $item->name);
                }
                if(!isset($var[1])) {
                    $var= explode(' Hot', $item->name);
                }

                $menup  = Menu::where('code', $code[0])->first();
                $menuv  = Menu::where('code', $code[1])->first();

                $all_row= [
                    'code'  => $code[0],
                    'type'  => $menup ? 'menu' : 'free',
                    'name'  => $var[0],
                    'group' => $item->category,
                    'price' => $item->price,
                    'description'   => null,
                    'gallery_url'   => 'https://www.malangculinary.com/upload/img_15944486022.jpg',
                    'gallery_title'     => 'foto',
                    'varian_type'       => $menuv ? 'menu' : 'free',
                    'varian_code'       => $code[1],
                    'varian_name'       => isset($var[1]) ? $var[1] : $item->name,
                    'varian_extra_price'=> 0,
                ];
                $recs   = $this->batch_product($recs, $all_row); 
            }else{
                $menup  = Menu::where('code', $code[0])->first();

                $all_row= [
                    'code'  => $item->code,
                    'type'  => $menup ? 'menu' : 'free',
                    'name'  => $item->name,
                    'group' => $item->category,
                    'price' => $item->price,
                    'description'   => null,
                    'gallery_url'   => 'https://www.malangculinary.com/upload/img_15944486022.jpg',
                    'gallery_title'     => 'foto',
                    'varian_type'       => null,
                    'varian_code'       => null,
                    'varian_name'       => null,
                    'varian_extra_price'=> 0,
                ];
                $recs   = $this->batch_product($recs, $all_row); 
            }
        }

        foreach ($recs as $k => $input) {
            $prod   = Product::where('code', $input['code'])->first();
            $id     = $prod ? $prod->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$prod){
                    $dt = CatalogAggregateRoot::retrieve($id)->save($input, [])->publish(now())->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC CATALOG');
                Log::info($e);
            }
        }
    }

    private function set_voucher() {
        $vous  = DB::connection('nakoa1')->table('reward_vouchers')->get();
        $recs   = [];
        foreach ($vous as $vou) {
            switch ($vou->type) {
                case 'DISCOUNT_ON_CHEAPEST':
                    $type   = 'BUY_AND_SAVE';
                    break;
                case 'TARGET_PRICE':
                    $type   = 'BUY_AND_PAY';
                    break;
                default:
                    $type   = 'DISCOUNT';
                    break;
            }
            
            if(Str::is('UNLIMITTED', $vou->quota_type)) {
                $quota  = 100000000;
            }else{
                $quota  = $vou->quota;
            }

            $tcc    = array_column(Product::whereIn('id', $vou->condition->product_ids)->get()->toArray(), 'code');
            $bcc    = array_column(Product::whereIn('id', $vou->value->product_ids)->get()->toArray(), 'code');
            $int    = array_intersect($tcc, $bcc);

            $code   = preg_split("/\s+/", $vou->caption);
            
            $input  = [
                'title'     => $vou->caption,
                'code'      => $code,
                'type'      => $type,
                'campaign'  => 'NAKOA',
                'mode'      => 'item',
                'quota'             => $quota,
                'quota_period'      => 'daily',
                'repeat_day'        => '*',
                'repeat_hour_start' => Carbon::parse($vou->condition->start_hour)->format('H:i:s'),
                'repeat_hour_end'   => Carbon::parse($vou->condition->end_hour)->format('H:i:s'),
                'terms'         => [
                    'catalog_codes' => empty($int) ? ['*'] : $int, 
                    'user_emails'   => ['*'],
                    'min_item'      => $vou->value->total_item - $vou->condition->min_items, 
                    'min_spent'     => $vou->condition->min_payable, 
                    'outlets'       => ['MLG01', 'MLG02'],
                ],
                'benefits'      => [
                    'catalog_codes'     => $bcc, 
                    'discounted_item'   => $vou->value->discounted_item,
                    'nominal'           => 0,
                    'percentage'        => $vou->value->discount,
                    'paid_amount'       => $vou->value->target_price ? $vou->value->target_price : 0,
                    'max_discount'      => 0,
                ],
            ];

            $vouc   = Promo::where('code', $input['code'])->first();
            $id     = $vouc ? $vouc->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$vouc){
                    $dt = PromoAggregateRoot::retrieve($id)->save($input, [])->publish($vou->actived_at, $vou->expired_at)->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC VOUCHER');
                Log::info($e);
            }
        }
    }

    private function set_sale() {
        $sos        = DB::connection('nakoa1')->table('sales_invoices')->orderby('updated_at', 'desc')->get();
        foreach ($sos as $so) {
            $nso    = SaleOrder::where('no', $so->no)->first();
            if(!$nso) {
                $lls    = json_decode($so->lines, true);
                $bills  = [];
                foreach ($lls as $ll) {
                    $vou        = DB::connection('nakoa1')->table('reward_vouchers')->where('id', $ll['voucher_id'] ? $ll['voucher_id'] : 0)->first();
                    $promo      = Promo::where('title', $vou ? $vou->caption : '---')->first();

                    $bills[]    = [
                        'description'   => $ll['name'],
                        'catalog_code'  => $ll['code'],
                        'catalog_price' => $ll['price'],
                        'rqs'           => 1,
                        'qty'           => 1,
                        'rcv'           => 0,
                        'dlv'           => 0,
                        'amount'        => $ll['price'] - $ll['discount'],
                        'flag'          => 'catalog',
                        'promo_code'    => $promo ? $promo->code : null,
                        'note'          => [],
                        'ux'            => []
                    ];
                }

                if($so->tax > 0) {
                    $bills[]    = [
                        'description'   => $so->label,
                        'catalog_code'  => null,
                        'catalog_price' => 0,
                        'rqs'           => 1,
                        'qty'           => 1,
                        'rcv'           => 0,
                        'dlv'           => 0,
                        'amount'        => $so->tax,
                        'flag'          => 'tax',
                        'promo_code'    => null,
                        'note'          => [],
                        'ux'            => [],
                    ];
                }

                $adm    = DB::connection('nakoa1')->table('user_users')->where('id', $so->admin_id)->first();
                $user   = User::where('phone', $adm ? $adm->username : '---')->first();

                //CALCUL
                $input  = [
                    'no'        => $so->no,
                    'no_ref'    => $so->offline_no,
                    'issued_at' => $so->date,
                    'marketplace'=> 'pos',
                    'outlet'    => $so->outlet_detail->code,
                    'courier'   => 'pickup',
                    'warehouse' => $so->outlet_detail->code,
                    'bills'     => $bills,
                    'shipping'  => [
                        'name'      => null,
                        'phone'     => null,
                        'address'   => null,
                        'deadline'  => null,
                        'notes'     => null,
                        'receipt'   => null,
                    ],
                    'store'     => [
                        'name'      => $so->outlet_detail->name,
                        'phone'     => null,
                        'address'   => $so->outlet_detail->address,
                    ],
                    'customer'  => [
                        'name'      => null,
                        'phone'     => null,
                        'address'   => null,
                    ],
                    'user_id'   => $user ? $user->id : null,
                ];

                $pay= [[
                    'method'  => $so->payment_type,
                    'amount'  => $so->payment_amount,
                    'no_ref'  => $so->payment_ref,
                    'date'    => $so->dat,
                    'user_id' => $user ? $user->id : null,
                ]];


                try {
                    DB::beginTransaction();
                    //SIMPAN
                    $id = $sno ? $sno->uuid : (string) Uuid::uuid4();
                    if($so->cancelled_at) {
                        $dt = SaleTransactionAggregateRoot::retrieve($id)->create($input)->void($so->cancel_note)->persist();
                    }else{
                        $dt = SaleTransactionAggregateRoot::retrieve($id)->create($input)->pay($pay)->persist();

                        //DO THE CHECKER
                        $nso    = SaleOrder::where('no', $so->no)->first();
                        $chids  = array_column(OrderChecker::where('order_id', $nso->id)->get()->toArray(), 'id');
                        $dt     = SaleTransactionAggregateRoot::retrieve($id)->checker($chids)->close()->persist();
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::info('SYNC SALE');
                    Log::info($e);
                }
            }
        }
    }

    private static function ceiling($number, $significance = 1) {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil((string)$number/$significance)*$significance) : false;
    }
}
