<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Validator, Auth, Exception, Log, Str, Excel, Storage;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;

use Lacunose\Manufacture\Models\Good;
use Lacunose\Manufacture\Models\Checker;
use Lacunose\Manufacture\Models\CheckerUsage;
use Lacunose\Manufacture\Aggregates\GoodAggregateRoot;
use Lacunose\Manufacture\Aggregates\CheckerAggregateRoot;

use Lacunose\Manufacture\Libraries\Traits\BatchGoodTrait;

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
    use BatchGoodTrait;
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

        // $this->set_good();

        $this->set_catalog();

        $this->set_promo();

         $take   = 100;
        $ttl    = DB::connection('nakoa1')->table('SALES_invoices')->orderby('no', 'asc')->count();
        $reg    = SaleOrder::count();
        $ttl    = min(100, ($ttl - $reg));
        
        $start  = $reg/100;
        $range  = ceil($ttl / $take) - 1;

        foreach (range($start, $range) as $step) {
            $skip   = $take*$step;
            $this->info("--------------------------------------------------------");
            $this->info('FROM '.$skip.' TO '.($skip + $take). ' FROM '.$ttl);
            $this->info("--------------------------------------------------------");
            
            Log::info('FROM '.$skip.' TO '.($skip + $take). ' FROM '.$ttl);
            
            $this->set_sale($skip, $take);
        }
    }

    private function set_good() {
        $recs   = [];
        $rscs   = [];

        if (($handle = fopen(storage_path('app\recipe.csv'), 'r')) !== FALSE) 
        {
            $header         = null;

            while (($data   = fgetcsv($handle, 500, ",")) !== FALSE) 
            {
                if ($header === null) 
                {
                    $header = $data;
                    continue;
                }
            
                $all_row    = array_combine($header, $data);
                $rscs[$all_row['item_code']]    = $all_row;
            }
        }
        $scls = [
            'KG'    => ['UNIT' => 'GRAM', 'RATIO' => 1000], 
            'LITER' => ['UNIT' => 'ML', 'RATIO' => 1000],
            'M'     => ['UNIT' => 'MM', 'RATIO' => 1000],
        ];
        $keys = ['KG', 'LITER', 'M'];

        $goods  = DB::connection('nakoa1')->table('APP_product_item')->get();
        foreach ($goods as $good) {
            $product= DB::connection('nakoa1')->table('SALES_products')->where('id', $good->product_id)->first();
            $item   = DB::connection('nakoa1')->table('WMS_items')->where('id', $good->item_id)->first();

            if($product && $item) {
                $record['code']     = $product->code;
                $record['name']     = $product->name;
                $record['station']  = 'BAR';
                $record['unit']     = 'PORSI';
                $record['cogs']     = 0;
                $record['qty']      = $good->qty;
                $record['resource_code'] = isset($rscs[$item->code]) ? $rscs[$item->code]['resource_code'] : $item->code;
                $record['resource_name'] = isset($rscs[$item->code]) ? $rscs[$item->code]['resource_name'] : $item->name;
                $record['resource_unit'] = isset($rscs[$item->code]) ? $rscs[$item->code]['resource_code'] : $item->unit;
                $record['resource_type'] = isset($rscs[$item->code]) ? $rscs[$item->code]['resource_type'] : 'item';
                
                $recs   = $this->batch_good($recs, $record); 
            }
        }

        //SIMPAN good
        foreach ($recs as $k => $input) {
            $prod   = Good::where('code', $input['code'])->first();
            $id     = $prod ? $prod->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$prod) {
                    $dt = GoodAggregateRoot::retrieve($id)->save($input, [])->publish(now())->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC good');
                Log::info($e);
            }
        }
    }

    private function set_catalog() {
        $items      = DB::connection('nakoa1')->table('SALES_products')->orderby('code', 'asc')->get();
        $recs       = [];
        foreach ($items as $item) {
            $code   = explode('-', $item->code);
            if(isset($code[1]) && !in_array(strtolower($item->category), ['food', 'extra'])) {
                $var    = explode(' Hot', $item->name);
                $vn     = 'Hot';
                if(!isset($var[1])) {
                    $var= explode('Ice L', $item->name);
                    $vn = 'Ice L';
                }

                if(!isset($var[1])) {
                    $var= explode('Ice R', $item->name);
                    $vn = 'Ice R';
                }

                $goodp  = Good::where('code', $code[0])->first();
                $goodv  = Good::where('code', $item->code)->first();
                $price  = isset($recs[$code[0]]) ? min($recs[$code[0]]['price'], $item->price) : $item->price;

                $all_row= [
                    'code'  => $code[0],
                    'type'  => $goodp ? 'good' : 'free',
                    'name'  => str_replace('Ice', '', $var[0]),
                    'group' => $item->category,
                    'price' => $price,
                    'description'   => null,
                    'gallery_url'   => 'https://www.malangculinary.com/upload/img_15944486022.jpg',
                    'gallery_title'     => 'foto',
                    'varian_type'       => $goodv ? 'good' : 'free',
                    'varian_code'       => $item->code,
                    'varian_name'       => $vn,
                    'varian_extra_price'=> $item->price - $price,
                ];
                $recs   = $this->batch_product($recs, $all_row); 
            }else{
                $goodp  = Good::where('code', $item->code)->first();

                $all_row= [
                    'code'  => $item->code,
                    'type'  => $goodp ? 'good' : 'free',
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

    private function set_sale($skip, $take = 100) {
        $sos        = DB::connection('nakoa1')->table('SALES_invoices')->orderby('no', 'asc')->skip($skip)->take($take)->get();
        foreach ($sos as $so) {
            $nso    = SaleOrder::where('no', $so->no)->first();
            if(!$nso) {
                $lls    = json_decode($so->lines, true);
                $bills  = [];
                foreach ($lls as $ll) {
                    $vou        = DB::connection('nakoa1')->table('REWARD_vouchers')->where('id', $ll['voucher_id'] ? $ll['voucher_id'] : 0)->first();
                    $promo      = Promo::where('title', $vou ? $vou->caption : '---')->first();
                    $good       = Good::where('code', $ll['code'])->first();

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
                        'ux'            => ['item' => [], 'good' => $good ? $good : []]
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
                    'recipient' => [
                        'name'      => null,
                        'phone'     => null,
                        'address'   => null,
                        'deadline'  => null,
                        'notes'     => null,
                        'receipt'   => null,
                    ],
                    'biller'    => [
                        'name'      => $outlet['name'],
                        'phone'     => null,
                        'address'   => $outlet['address'],
                    ],
                    'payer'     => [
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
                        $dt = SaleTransactionAggregateRoot::retrieve($id)->create($input)->confirm()->pay($pay)->close()->persist();
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
