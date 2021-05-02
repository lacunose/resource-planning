<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Validator, Auth, Exception, Log, Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;

use Lacunose\Procure\Models\Order as ProcureOrder;
use Lacunose\Procure\Aggregates\TransactionAggregateRoot as ProcureTransactionAggregateRoot;

use Lacunose\Warehouse\Models\Item;
use Lacunose\Warehouse\Models\Document;
use Lacunose\Warehouse\Aggregates\ItemAggregateRoot;
use Lacunose\Warehouse\Aggregates\DocumentAggregateRoot;

use Lacunose\Finance\Models\Coa;
use Lacunose\Finance\Models\Book;
use Lacunose\Finance\Aggregates\CoaAggregateRoot;
use Lacunose\Finance\Aggregates\BookAggregateRoot;

class NakoaV1SyncProcure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nakoa:sync:procure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data pembelian dari nakoa versi 1';

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
            
        // $this->set_coa();

        $this->set_item();

        // $this->restok_from_po();
    }

    private function set_coa() {
        $coas       = DB::connection('nakoa1')->table('ACCOUNTING_coas')->get();

        foreach ($coas as $coa) {
            $ncoa   = Coa::where('code', $coa->code)->first();
            if(Str::is('*ASSET', $coa->type) || in_array($coa->type, ['CASH', 'BANK', 'ACCOUNT_RECEIVABLE', 'AMORTIZATION_DEPRECIATION'])) {
                $group  = 'asset';
            }elseif(Str::is('*LIABILITY', $coa->type) || in_array($coa->type, ['ACCOUNT_PAYABLE'])) {
                $group  = 'liability';
            }elseif(Str::is('*EQUITY', $coa->type)) {
                $group  = 'equity';
            }elseif(Str::is('*INCOME', $coa->type) || in_array($coa->type, ['COGS'])) {
                $group  = 'revenue';
            }elseif(Str::is('*EXPENSE', $coa->type)) {
                $group  = 'expense';
            }else{
                $group  = 'statistic';
            }

            $equ    = false;
            if(Str::is('*Bulan Berjalan', $coa->name)) {
                $equ= true;
            }

            $path   = $coa->code;
            if($coa->parent_id) {
                $parent = DB::connection('nakoa1')->table('ACCOUNTING_coas')->where('id', $coa->parent_id)->first();
                $path   = $parent->code.','.$path;

            }

            $inp1   = [
                'name'      => $coa->name,
                'code'      => $coa->code,
                'tag'       => $coa->type,
                'group'     => $group,
                'path'      => $path,
                'is_equity' => $equ,
                'currency'  => 'IDR',
            ];


            if(!$ncoa) {
                $id = $ncoa ? $ncoa->uuid : (string) Uuid::uuid4();
                try {
                    DB::BeginTransaction();
                    $dt = CoaAggregateRoot::retrieve($id)->update($inp1)->persist();
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::info('SYNC COA');
                    Log::info($e);
                }
            }

        }
    }

    private function set_item(){
        $items      = DB::connection('nakoa1')->table('WMS_items')->get();
        foreach ($items as $item) {
            $nitem  = Item::where('code', $item->code)->first();
            $gals   = [];
            
            $input  = [
                'name'      => $item->name,
                'code'      => $item->code,
                'type'      => $item->category,
                'unit'      => $item->unit,
                'galleries' => $gals,
            ];

            if(!$nitem) {
                $id = $nitem ? $nitem->uuid : (string) Uuid::uuid4();
                try {
                    DB::BeginTransaction();
                    $dt = ItemAggregateRoot::retrieve($id)->draft($input)->submit()->persist();
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::info('SYNC ITEM');
                    Log::info($e);
                }
            }
        }
    }

    private function restok_from_po() {
        $pos        = DB::connection('nakoa1')->table('PURC_documents')->get();
        foreach ($pos as $po) {
            $npo    = ProcureOrder::where('no', $po->no)->first();
            if(!$npo) {
                $lls    = json_decode($po->lines, true);
                $bills  = [];
                $tax    = 0;
                $ttl    = 0;

                //GENERATE INPUT PO
                foreach ($lls as $ll) {
                    $item       = Item::where('code', $ll['code'])->first();
                    $bills[]    = [
                        'description'   => $ll['name'],
                        'catalog_code'  => $ll['code'],
                        'catalog_price' => $ll['total']/max(1, $ll['qty']),
                        'rqs'           => $ll['qty'],
                        'qty'           => $ll['qty'],
                        'rcv'           => 0,
                        'dlv'           => 0,
                        'amount'        => $ll['total']/max(1, $ll['qty']),
                        'flag'          => 'catalog',
                        'unit'          => $ll['unit'],
                        'note'          => [],
                        'ux'            => ['item' => $item ? $item->toArray() : []]
                    ];

                    $tax    = $tax + $ll['tax'];
                    $ttl    = $ttl + $ll['total'];
                }

                if($tax) {
                    $bills[]    = [
                        'description'   => 'Pajak',
                        'catalog_code'  => null,
                        'catalog_price' => 0,
                        'rqs'           => 1,
                        'qty'           => 1,
                        'rcv'           => 0,
                        'dlv'           => 0,
                        'amount'        => $tax,
                        'flag'          => 'tax',
                        'unit'          => $ll['unit'],
                        'note'          => [],
                        'ux'            => [],
                    ];
                }
                $ref    = DB::connection('nakoa1')->table('PURC_documents')
                        ->Where('id', $po->ref_doc_id ? $po->ref_doc_id : 0)->first();
                
                $outlet = json_decode($po->outlet_detail, true);
                $vendor = json_decode($po->supplier_detail, true);
                $input  = [
                    'no'        => $po->no,
                    'no_ref'    => $ref ? $ref->no : null,
                    'issued_at' => $po->date,
                    'mode'      => 'pembelian',
                    'branch'    => $outlet['code'],
                    'vendor'    => $vendor['name'],
                    'warehouse' => $outlet['code'],
                    'bills'     => $bills,
                    'recipient' => [
                        'name'      => $outlet['name'],
                        'phone'     => null,
                        'address'   => $outlet['address'].', '.$outlet['city'].'-'.$outlet['province'],
                        'notes'     => $po->note,
                        'receipt'   => null,
                        'deadline'  => $po->ship_at,
                    ],
                    'biller'        => [
                        'name'      => $vendor['name'],
                        'phone'     => null,
                        'address'   => $vendor['address'].', '.$vendor['city'].'-'.$vendor['province'],
                    ],
                    'payer'         => [
                        'name'      => 'NAKOA',
                        'phone'     => null,
                        'address'   => 'Jl. Letjen Sutoyo No.102, Kota Malang, Jawa Timur 65141',
                    ],
                ];

                $pay    = [[
                    'method'  => 'Pembayaran',
                    'amount'  => $ttl,
                    'no_ref'  => null,
                    'date'    => $po->date,
                    'user_id' => auth::check() ? auth::id() : null,
                ]];

                //GENERATE INPUT WH
                $whs    = DB::connection('nakoa1')->table('WMS_documents')->where('ref_doc_type', 'App\Domain\Purchasing\PurchaseOrder')->where('ref_doc_id', $po->id)->get();
                $inpwh  = [];

                foreach ($whs as $wh) {
                    $lns    = json_decode($wh->lines, true);
                    $lines  = [];
                    $stocks = [];

                    foreach ($lns as $ln) {
                        $item       = Item::where('code', $ln['code'])->first();

                        $lines[]    = [
                            'item_code'     => $item->code,
                            'description'   => $ln['name'],
                            'unit'          => $item->unit,
                            'qty'           => $ln['qty'],
                            'scale_unit'    => $item->unit,
                            'scale_qty'     => $ln['qty'],
                            'scale_ratio'   => 1,
                        ];

                        if($item) {
                            $stocks[]   = [
                                'item_id'       => $item->id,
                                'item_code'     => $item->code,
                                'item_unit'     => $item->unit,
                                'batch'         => $item->code,
                                'owner'         => 'nakoa',
                                'description'   => $ln['name'],
                                'qty'           => $ln['qty'],
                                'expired_at'    => null,
                                'note'          => '',
                            ];
                        }else{
                            \Log::info('Unlisted: '.$ln['code']);
                        }
                    }

                    $inpwh[$wh->no] = [
                        'title'     => 'Stok masuk #'.$po->no,
                        'no'        => $wh->no,
                        'no_ref'    => $po->no,
                        'cause'     => 'masuk',
                        'owner'     => 'nakoa',
                        'type'      => 'receiving',
                        'warehouse' => $outlet['code'],
                        'date'      => $wh->date,
                        'lines'     => $lines,
                        'sender'    => [
                            'name'      => $vendor['name'],
                            'phone'     => null,
                            'address'   => $vendor['address'].', '.$vendor['city'].'-'.$vendor['province'],
                            'receipt'   => null,
                            'courier'   => null,
                        ],
                        'receiver'  => [
                            'name'      => $outlet['name'],
                            'phone'     => null,
                            'address'   => $outlet['address'].', '.$outlet['city'].'-'.$outlet['province'],
                        ],
                        'stocks'    => $stocks,
                    ];
                }


                try {
                    DB::BeginTransaction();
                    $id = $npo ? $npo->uuid : (string) Uuid::uuid4();
                    if(in_array($po->status, ['CANCELLED'])) {
                        $dt = ProcureTransactionAggregateRoot::retrieve($id)->create($input)->void('unknown')->persist();
                    }elseif(in_array($po->status, ['RECEIVED', 'PARTIALLY RECEIVED'])) {
                        $dt = ProcureTransactionAggregateRoot::retrieve($id)->create($input)->process('confirmed')->pay($pay)->persist();
                        foreach ($inpwh as $inp) {
                            $dwh    = Document::no($po->no)->where('status', 'opened')->first();
                            $id2    = $dwh ? $dwh->uuid : (string) Uuid::uuid4();
                            $dt     = DocumentAggregateRoot::retrieve($id2)->create($inp)->confirm()->stock($inp['stocks'])->approve()
                                ->close()->persist();
                        }
                        $dt = ProcureTransactionAggregateRoot::retrieve($id)->close()->persist();
                    }
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::info('SYNC PROCURE');
                    Log::info($e);
                }
            }
        }
    }

    private static function ceiling($number, $significance = 1) {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil((string)$number/$significance)*$significance) : false;
    }
}
