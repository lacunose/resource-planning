<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Validator, Auth, Exception, Log, Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;

use Lacunose\Warehouse\Models\Item;
use Lacunose\Warehouse\Models\Document;
use Lacunose\Warehouse\Aggregates\DocumentAggregateRoot;

class NakoaV1SyncWarehouse extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nakoa:sync:warehouse';

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

        $this->set_adf();

        $this->set_mvm();

        $this->set_opname();
    }

    private function set_adf() {
        $adfs   = DB::connection('nakoa1')->table('WMS_documents')->where('type', 'ADF')->get();
        $recs   = [];
        foreach ($adfs as $wh) {
            $lns    = json_decode($wh->lines, true);
            $lines  = [];
            $stocks = [];


            if( preg_match('/\btester\b/i', strtolower($wh->note) ) ){
                $note   = 'unidentified';
            }elseif( preg_match('/\bkadaluarsa\b/i', strtolower($wh->note)) 
                || preg_match('/\bexp\b/i', strtolower($wh->note)) 
                || preg_match('/\bjamur\b/i', strtolower($wh->note)) 
                || preg_match('/\bbasi\b/i', strtolower($wh->note))
                || preg_match('/\bumur\b/i', strtolower($wh->note))
                || preg_match('/\bbuang\b/i', strtolower($wh->note))
            ){
                $note   = 'spoiled';
            }elseif( preg_match('/\bjamur\b/i', strtolower($wh->note)) 
                || preg_match('/\bbasi\b/i', strtolower($wh->note))
                || preg_match('/\bbuang\b/i', strtolower($wh->note))
            ){
                $note   = 'expired';
            }else{
                $note   = 'unidentified';
            }

            foreach ($lns as $ln) {
                $item       = Item::where('code', $ln['code'])->first();

                $lines[]    = [
                    'item_code'     => $ln['code'],
                    'description'   => $ln['name'],
                    'amount'        => $ln['qty'],
                ];

                if($item) {
                    $stocks[]   = [
                        'item_id'       => $item->id,
                        'item_code'     => $ln['code'],
                        'batch'         => $ln['code'],
                        'owner'         => 'nakoa',
                        'description'   => $ln['name'],
                        'amount'        => $ln['qty'] * -1,
                        'expired_at'    => null,
                        'note'          => $note,
                    ];
                }else{
                    \Log::info('Unlisted: '.$ln['code']);
                }
            }

            $whouse = DB::connection('nakoa1')->table('WMS_warehouses')->where('id', $wh->warehouse_id)->first();

            $input  = [
                'title'     => 'Perubahan stok karena '.$wh->note,
                'no'        => $wh->no,
                'cause'     => 'inhouse',
                'owner'     => 'nakoa',
                'type'      => 'penyesuaian',
                'warehouse' => $whouse->code,
                'date'      => $wh->date,
                'lines'     => $lines,
                'sender'    => [
                    'name'      => null,
                    'phone'     => null,
                    'address'   => null,
                    'receipt'   => null,
                    'courier'   => null,
                ],
                'receiver'  => [
                    'name'      => null,
                    'phone'     => null,
                    'address'   => null,
                ],
                'stocks'    => $stocks,
            ];

            $doc   = Document::where('no', $input['no'])->first();
            $id     = $doc ? $doc->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$doc){
                    $dt = DocumentAggregateRoot::retrieve($id)->draft($input, [])->stock($input['stocks'], [])->lock([])->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC ADF');
                Log::info($e);
            }

        }
    }

    private function set_mvm() {
        $grns   = DB::connection('nakoa1')->table('WMS_documents')->where('type', 'GRN')->where('ref_doc_type', 'App\Domain\Wms\GDN')->get();
        $recs   = [];
        foreach ($grns as $wh) {
            $wh2    = DB::connection('nakoa1')->table('WMS_documents')->where('id', $wh->ref_doc_id)->first();
            $whouse = DB::connection('nakoa1')->table('WMS_warehouses')->where('id', $wh->warehouse_id)->first();
            $whouse2= DB::connection('nakoa1')->table('WMS_warehouses')->where('id', $wh2->warehouse_id)->first();
            
            $lns    = json_decode($wh->lines, true);
            $lines  = [];
            $stocks = [];

            foreach ($lns as $ln) {
                $item       = Item::where('code', $ln['code'])->first();

                $lines[]    = [
                    'item_code'     => $ln['code'],
                    'description'   => $ln['name'],
                    'amount'        => $ln['qty'],
                ];

                if($item) {
                    $stocks[]   = [
                        'item_id'       => $item->id,
                        'item_code'     => $ln['code'],
                        'batch'         => $ln['code'],
                        'owner'         => 'nakoa',
                        'description'   => $ln['name'],
                        'amount'        => $ln['qty'],
                        'expired_at'    => null,
                        'note'          => '',
                    ];
                }else{
                    \Log::info('Unlisted: '.$ln['code']);
                }
            }

            $input  = [
                'title'     => 'Stok masuk karena perpindahan',
                'no'        => $wh->no,
                'cause'     => 'masuk',
                'owner'     => 'nakoa',
                'type'      => 'perpindahan',
                'warehouse' => $whouse->code,
                'date'      => $wh->date,
                'lines'     => $lines,
                'sender'    => [
                    'name'      => $whouse->name,
                    'phone'     => null,
                    'address'   => null,
                    'receipt'   => null,
                    'courier'   => null,
                ],
                'receiver'  => [
                    'name'      => $whouse2->name,
                    'phone'     => null,
                    'address'   => null,
                ],
                'stocks'    => $stocks,
            ];

            //INP 2
            $lns    = json_decode($wh2->lines, true);
            $lines  = [];
            $stocks = [];

            foreach ($lns as $ln) {
                $item       = Item::where('code', $ln['code'])->first();

                $lines[]    = [
                    'item_code'     => $ln['code'],
                    'description'   => $ln['name'],
                    'amount'        => $ln['qty'],
                ];

                if($item) {
                    $stocks[]   = [
                        'item_id'       => $item->id,
                        'item_code'     => $ln['code'],
                        'batch'         => $ln['code'],
                        'owner'         => 'nakoa',
                        'description'   => $ln['name'],
                        'amount'        => $ln['qty'] * -1,
                        'expired_at'    => null,
                        'note'          => '',
                    ];
                }else{
                    \Log::info('Unlisted: '.$ln['code']);
                }
            }

            $input2 = [
                'title'     => 'Stok keluar karena perpindahan',
                'no'        => $wh2->no,
                'cause'     => 'keluar',
                'owner'     => 'nakoa',
                'type'      => 'perpindahan',
                'warehouse' => $whouse2->code,
                'date'      => $wh2->date,
                'lines'     => $lines,
                'sender'    => [
                    'name'      => $whouse2->name,
                    'phone'     => null,
                    'address'   => null,
                    'receipt'   => null,
                    'courier'   => null,
                ],
                'receiver'  => [
                    'name'      => $whouse->name,
                    'phone'     => null,
                    'address'   => null,
                ],
                'stocks'    => $stocks,
            ];

            $doc    = Document::where('no', $input['no'])->first();
            $id     = $doc ? $doc->uuid : (string) Uuid::uuid4();

            $doc2   = Document::where('no', $input2['no'])->first();
            $id2    = $doc2 ? $doc2->uuid : (string) Uuid::uuid4();
            
            try {
                DB::beginTransaction();
                if(!$doc){
                    $dt = DocumentAggregateRoot::retrieve($id)->draft($input, [])->stock($input['stocks'], [])->lock([])->persist();
                }
                if(!$doc2){
                    $dt = DocumentAggregateRoot::retrieve($id2)->draft($input2, [])->stock($input2['stocks'], [])->lock([])->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC MVM');
                Log::info($e);
            }

        }
    }

    private function set_opname() {
        $ops    = DB::connection('nakoa1')->table('WMS_documents')->where('type', 'GRN')->wherenull('ref_doc_type')->get();
        $recs   = [];
        foreach ($ops as $wh) {
            $lns    = json_decode($wh->lines, true);
            $lines  = [];
            $stocks = [];

            foreach ($lns as $ln) {
                $item       = Item::where('code', $ln['code'])->first();

                $lines[]    = [
                    'item_code'     => $ln['code'],
                    'description'   => $ln['name'],
                    'amount'        => $ln['qty'],
                ];

                if($item) {
                    $stocks[]   = [
                        'item_id'       => $item->id,
                        'item_code'     => $ln['code'],
                        'batch'         => $ln['code'],
                        'owner'         => 'nakoa',
                        'description'   => $ln['name'],
                        'amount'        => $ln['qty'],
                        'expired_at'    => null,
                        'note'          => '',
                    ];
                }else{
                    \Log::info('Unlisted: '.$ln['code']);
                }
            }

            $whouse = DB::connection('nakoa1')->table('WMS_warehouses')->where('id', $wh->warehouse_id)->first();

            $input  = [
                'title'     => 'Perubahan stok karena penyesuaian opname',
                'no'        => $wh->no,
                'cause'     => 'inhouse',
                'owner'     => 'nakoa',
                'type'      => 'opname',
                'warehouse' => $whouse->code,
                'date'      => $wh->date,
                'lines'     => $lines,
                'sender'    => [
                    'name'      => null,
                    'phone'     => null,
                    'address'   => null,
                    'receipt'   => null,
                    'courier'   => null,
                ],
                'receiver'  => [
                    'name'      => null,
                    'phone'     => null,
                    'address'   => null,
                ],
                'stocks'    => $stocks,
            ];

            $doc   = Document::where('no', $input['no'])->first();
            $id     = $doc ? $doc->uuid : (string) Uuid::uuid4();

            try {
                DB::beginTransaction();
                if(!$doc){
                    $dt = DocumentAggregateRoot::retrieve($id)->draft($input, [])->stock($input['stocks'], [])->lock([])->persist();
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info('SYNC ADF');
                Log::info($e);
            }

        }
    }
}
