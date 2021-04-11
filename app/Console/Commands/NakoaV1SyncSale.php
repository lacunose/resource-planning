<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Validator, Auth, Exception, Log, Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;

use Lacunose\Manufacture\Models\Menu;
use Lacunose\Manufacture\Models\Document;
use Lacunose\Manufacture\Models\DocumentChecker;
use Lacunose\Manufacture\Aggregates\MenuAggregateRoot;
use Lacunose\Manufacture\Aggregates\DocumentAggregateRoot;

use Lacunose\Manufacture\Libraries\Traits\BatchMenuTrait;

use Lacunose\Sale\Models\Promo;
use Lacunose\Sale\Models\Product;
use Lacunose\Sale\Models\ProductVarian;
use Lacunose\Sale\Models\Order as SaleOrder;
use Lacunose\Sale\Aggregates\PromoAggregateRoot;
use Lacunose\Sale\Aggregates\CatalogAggregateRoot;
use Lacunose\Sale\Aggregates\TransactionAggregateRoot as SaleTransactionAggregateRoot;

use Lacunose\Sale\Libraries\Traits\BatchCatalogTrait;

use Lacunose\Finance\Models\Coa;
use Lacunose\Finance\Models\Book;
use Lacunose\Finance\Aggregates\CoaAggregateRoot;
use Lacunose\Finance\Aggregates\BookAggregateRoot;

class NakoaV1SyncSale extends Command
{
    use BatchCatalogTrait;
    use BatchMenuTrait;
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

        $this->set_promo();

        $this->set_sale();
    }

    private function set_menu() {
        $menus  = DB::connection('nakoa1')->table('APP_product_item')->get();
        $recs   = [];
        foreach ($menus as $menu) {
            $product= DB::connection('nakoa1')->table('SALES_products')->where('id', $menu->product_id)->first();
            $item   = DB::connection('nakoa1')->table('WMS_items')->where('id', $menu->item_id)->first();

            if($product && $item) {
                $all_row['code']    = $product->code;
                $all_row['name']    = $product->name;
                $all_row['station'] = $product->category;
                $all_row['cogs']    = 0;
                $all_row['item_code']   = $item->code;
                $all_row['item_name']   = $item->name;
                $all_row['amount']      = $menu->qty;
                $all_row['cost']        = 0;
                $all_row['is_synced']   = Str::is($item->category, 'Packaging') ? true : false;
                
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
        $items      = DB::connection('nakoa1')->table('SALES_products')->get();
        $recs       = [];
        foreach ($items as $item) {
            $code   = explode('-', $item->code);
            if(isset($code[1])) {
                $var    = explode(' R', $item->name);
                $vn     = 'Ice R';
                if(!isset($var[1])) {
                    $var= explode(' L', $item->name);
                    $vn = 'Ice L';
                }

                if(!isset($var[1])) {
                    $var= explode(' Hot', $item->name);
                    $vn = 'Hot';
                }

                $menup  = Menu::where('code', $code[0])->first();
                $menuv  = Menu::where('code', $item->code)->first();
                $price  = isset($recs[$code[0]]) ? min($recs[$code[0]]['price'], $item->price) : $item->price;

                $all_row= [
                    'code'  => $code[0],
                    'type'  => $menup ? 'menu' : 'free',
                    'name'  => str_replace('Ice', '', $var[0]),
                    'group' => $item->category,
                    'price' => $price,
                    'description'   => null,
                    'gallery_url'   => 'https://www.malangculinary.com/upload/img_15944486022.jpg',
                    'gallery_title'     => 'foto',
                    'varian_type'       => $menuv ? 'menu' : 'free',
                    'varian_code'       => $item->code,
                    'varian_name'       => $vn,
                    'varian_extra_price'=> $item->price - $price,
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

    private function set_promo() {
        $vous  = DB::connection('nakoa1')->table('REWARD_vouchers')->get();
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
            
            if(Str::is('UNLIMITED', $vou->quota_type)) {
                $quota  = 100000000;
            }else{
                $quota  = $vou->quota;
            }

            $terms  = json_decode($vou->condition, true);
            $benfs  = json_decode($vou->value, true);

            $ccf    = DB::connection('nakoa1')->table('SALES_products')->whereIn('id', $terms['product_ids'])->get()->toArray();
            $vcf    = DB::connection('nakoa1')->table('SALES_products')->whereIn('id', $benfs['product_ids'])->get()->toArray();

            $ccc    = Product::whereIn('code', array_column($ccf, 'code'))->get()->toArray();
            $vcc    = Product::whereIn('code', array_column($vcf, 'code'))->get()->toArray();

            $ccc    = array_merge($ccc, ProductVarian::whereIn('code', array_column($ccf, 'code'))->with(['product'])->get()->toArray());
            $vcc    = array_merge($vcc, ProductVarian::whereIn('code', array_column($vcf, 'code'))->with(['product'])->get()->toArray());

            $tcc    = array_column($ccc, 'code');
            $bcc    = array_column($vcc, 'code');

            $tcn    = array_column($ccc, 'ux_name');
            $bcn    = array_column($vcc, 'ux_name');

            if(in_array($type, ['BUY_AND_PAY'])) {
                $tcc= array_diff($tcc, $bcc);
                $tcn= array_diff($tcn, $bcn);
            }

            $code   = strtoupper(Str::random(6));
            
            $input  = [
                'title'     => $vou->caption,
                'code'      => $code,
                'type'      => $type,
                'campaign'  => 'NAKOA',
                'mode'      => 'catalog',
                'quota'             => $quota,
                'quota_period'      => 'daily',
                'repeat_days'       => ['*'],
                'repeat_hour_start' => Carbon::parse($terms['start_hour'])->format('H:i'),
                'repeat_hour_end'   => Carbon::parse($terms['end_hour'])->format('H:i'),
                'terms'         => [
                    'catalog_codes' => empty($tcc) ? ['*'] : $tcc, 
                    'catalog_names' => empty($tcn) ? ['Semua Item'] : $tcn, 
                    'min_item'      => $terms['min_items'] - $benfs['discounted_item'], 
                    'min_spent'     => $terms['min_payable'], 
                ],
                'benefits'      => [
                    'catalog_codes'     => empty($bcc) ? ['*'] : $bcc, 
                    'catalog_names'     => empty($bcn) ? ['Semua Item'] : $bcn, 
                    'discounted_item'   => $benfs['discounted_item'],
                    'nominal'           => 0,
                    'percentage'        => $benfs['discount'],
                    'paid_amount'       => isset($benfs['target_price']) ? $benfs['target_price'] : 0,
                    'max_discount'      => 0,
                ],
            ];

            $vouc   = Promo::where('title', $input['title'])->first();
            $id     = $vouc ? $vouc->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$vouc){
                    $dt = PromoAggregateRoot::retrieve($id)->save($input)->activate($vou->active_at, $vou->expired_at)->persist();
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
        $sos        = DB::connection('nakoa1')->table('SALES_invoices')->orderby('updated_at', 'desc')->get();
        foreach ($sos as $so) {
            $nso    = SaleOrder::where('no', $so->no)->first();
            if(!$nso) {
                $lls    = json_decode($so->lines, true);
                $bills  = [];
                foreach ($lls as $ll) {
                    $vou        = DB::connection('nakoa1')->table('REWARD_vouchers')->where('id', $ll['voucher_id'] ? $ll['voucher_id'] : 0)->first();
                    $promo      = Promo::where('title', $vou ? $vou->caption : '---')->first();
                    $menu       = Menu::where('code', $ll['code'])->first();

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
                        'ux'            => ['item' => [], 'menu' => $menu ? $menu : []]
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

                $adm    = DB::connection('nakoa1')->table('USER_users')->where('id', $so->admin_id)->first();
                $user   = User::where('phone', $adm ? $adm->username : '---')->first();
                $outlet = json_decode($so->outlet_detail, true);

                //CALCUL
                $input  = [
                    'no'        => $so->no,
                    'no_ref'    => $so->offline_no,
                    'issued_at' => $so->date,
                    'marketplace'=> 'pos',
                    'outlet'    => $outlet['code'],
                    'courier'   => 'pickup',
                    'warehouse' => $outlet['code'],
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
                        'name'      => $outlet['name'],
                        'phone'     => null,
                        'address'   => $outlet['address'],
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
                    'date'    => $so->date,
                    'user_id' => $user ? $user->id : null,
                ]];


                try {
                    DB::beginTransaction();
                    //SIMPAN
                    $id = $nso ? $nso->uuid : (string) Uuid::uuid4();
                    if($so->cancelled_at) {
                        $dt = SaleTransactionAggregateRoot::retrieve($id)->create($input)->void($so->cancel_note)->persist();
                    }else{
                        $dt = SaleTransactionAggregateRoot::retrieve($id)->create($input)->process('confirmed')->pay($pay)->persist();

                        $docs   = Document::where('no_ref', $so->no)->get();
                        foreach ($docs as $doc) {
                            $ids= array_column(DocumentChecker::where('document_id', $doc->id)->wherenull('delivered_at')->get()->toArray(), 'id');
                            $dt = DocumentAggregateRoot::retrieve($doc->uuid)->submit($ids)->persist();
                        }
                        //DO THE CHECKER
                        $dt     = SaleTransactionAggregateRoot::retrieve($id)->close()->persist();
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
