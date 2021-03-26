<?php

namespace App\Reactors;

use Str, Storage, DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

use App\User;
use App\AppConflict;
use Laravel\Passport\Token;

use Lacunose\Sale\Models\Order;
use Lacunose\Sale\Models\OrderBill;

use Lacunose\Warehouse\Models\Item;
use Lacunose\Warehouse\Models\ItemStat;
use Lacunose\Warehouse\Models\Report;
use Lacunose\Warehouse\Models\Document;

use Lacunose\Finance\Models\Book;

use Lacunose\Sale\Aggregates\TransactionAggregateRoot;
use Lacunose\Warehouse\Aggregates\DocumentAggregateRoot;
use Lacunose\Finance\Aggregates\BookAggregateRoot;

/*----------  Events  ----------*/
use Lacunose\Sale\Events\Transaction\Created;
use Lacunose\Sale\Events\Transaction\Updated;
use Lacunose\Sale\Events\Transaction\Printed;
use Lacunose\Sale\Events\Transaction\Assigned;
use Lacunose\Sale\Events\Transaction\Discussed;
use Lacunose\Sale\Events\Transaction\Processed;
use Lacunose\Sale\Events\Transaction\Closed;
use Lacunose\Sale\Events\Transaction\Voided;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

final class SaleTransactionReactor extends Reactor {

    private function wh_usage_cutoff_daily($event, $trs) {
        //tanggal
        if(!Str::is($trs->warehouse, 'dropship')){
            $start  = Carbon::parse($trs->issued_at)->startOfDay();
            $end    = Carbon::parse($trs->issued_at)->endOfDay();

            $doc    = Document::where('date', $end)->first();
            $bills  = OrderBill::wherehas('order', function($q)use($trs, $start, $end){
                $q->where('warehouse', $trs->warehouse)
                ->where('issued_at', '>=', $start)
                ->where('issued_at', '<=', $end)
                ->whereIn('status', ['confirmed', 'processed', 'closed']);
            })->get();

            $lines      = [];
            $stocks     = [];

            foreach ($bills as $line) {
                if($line->ux_has_item && !empty($line->ux['item'])) {
                    $item       = $line->ux['item'];
                    $lines[]    = [
                        'item_code'     => $item['code'], 
                        'description'   => $item['name'], 
                        'amount'        => $line['qty']
                    ];

                    $stocks[]   = [
                        'item_id'       => $item['id'],
                        'item_code'     => $item['code'],
                        'batch'         => $item['code'], 
                        'owner'         => $trs->warehouse, 
                        'expired_at'    => null, 
                        'description'   => $item['name'], 
                        'amount'        => $line['qty'] * -1
                    ];
                }
            }

            $uuid       =  (string) Uuid::uuid4();
            if($doc){
                $uuid   = $doc->uuid;
            }

            if(count($lines)) {
                $doc        = DocumentAggregateRoot::retrieve($uuid)->draft([
                    'title'     => 'Penggunaan '.$start->format('d/m/Y'),
                    'cause'     => 'keluar',
                    'owner'     => '',
                    'warehouse' => $trs->warehouse,
                    'type'      => 'usage',
                    'date'      => $end->format('Y-m-d H:i:s'),
                    'status'    => 'drafted',
                    'lines'     => $lines,
                    'sender'    => [
                        'name'   => $trs->store['name'],
                        'phone'  => $trs->store['phone'],
                        'address'=> $trs->store['address'],
                        'receipt'=> $trs->shipping['receipt'],
                        'courier'=> $trs->courier,
                    ],
                    'receiver'      => $trs->shipping,
                    'requested_at'  => $end->format('Y-m-d H:i:s'),
                ], [])->stock($stocks, [])->persist();
            }
        }
    }

    private function wh_usage_cutoff_transaction($event, $trs) {
        $ono    = $trs->no;
        $doc    = Document::where('no_ref', $ono)->first();
        
        if(!Str::is($trs->warehouse, 'dropship') && !$doc){

            $lines      = [];
            $stocks     = [];

            foreach ($trs->bills as $line) {
                if($line->ux_has_item && !empty($line->ux['item'])) {
                    $item       = $line->ux['item'];
                    $lines[]    = [
                        'item_code'     => $item['code'], 
                        'description'   => $item['name'], 
                        'amount'        => $line['qty']
                    ];

                    if($item){
                        $stocks[]   = [
                            'item_id'       => $item['id'],
                            'item_code'     => $item['code'],
                            'batch'         => null, 
                            'owner'         => null, 
                            'expired_at'    => null, 
                            'description'   => $item['name'], 
                            'amount'        => $line['qty'] * -1
                        ];
                    }
                }
            }

            $uuid       =  (string) Uuid::uuid4();
            if($doc){
                $uuid   = $doc->uuid;
            }

            $doc        = DocumentAggregateRoot::retrieve($uuid)->draft([
                'id'        => 0,
                'no_ref'    => $ono,
                'title'     => 'Delivery Order #'.$trs->no,
                'cause'     => 'keluar',
                'owner'     => '',
                'warehouse' => $trs->warehouse,
                'type'      => 'delivery_order',
                'date'      => $event->when->format('Y-m-d H:i:s'),
                'status'    => 'drafted',
                'lines'     => $lines,
                'sender'    => [
                    'name'   => $trs->store['name'],
                    'phone'  => $trs->store['phone'],
                    'address'=> $trs->store['address'],
                    'receipt'=> $trs->shipping['receipt'],
                    'courier'=> $trs->courier,
                ],
                'receiver'      => $trs->shipping,
                'requested_at'  => $trs->issued_at->format('Y-m-d H:i:s'),
            ], [])->persist();
        }elseif(Str::is($trs->warehouse, 'dropship') && $doc){
            $doc    = DocumentAggregateRoot::retrieve($doc->uuid)->archive([])->persist();
        }
    }

    private function generate_flow($trs, $when, $who){
        if(is_null($trs->processes)){
            $trs->processes  =  [
                'confirmed'     => ['state' => 'Confirmed', 'is_executed' => false, 'when' => null, 'who' => null],
                'served'        => ['state' => 'Served', 'is_executed' => false, 'when' => null, 'who' => null],
            ];
            $trs->save();
        }
    }

    private function stock_alert($trs, $when, $who){
        $agent = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();

        if(!Str::is($trs->warehouse, 'dropship')){

            $lines  = $trs->bills()->where('flag', 'item')->get();

            foreach ($lines as $line) {
                if($line->ux_has_item && empty($line->ux['item'])){
                    $msg    = 'Kode item '.$line['catalog_code'].' tidak terdaftar';
                    $chat   = TransactionAggregateRoot::retrieve($trs->uuid)->discuss($msg, $agent ? $agent : null)->persist();
                }elseif($line->ux_has_item) {
                    //UPDATE ITEM STAT
                    $stat   = ItemStat::where('item_id', $line->ux['item']['id'])->where('warehouse', $trs->warehouse)->firstornew();
                    $stat->item_id          = $line->ux['item']['id'];
                    $stat->warehouse        = $trs->warehouse;
                    $stat->reserved_stock   = OrderBill::where('catalog_code', $line->catalog_code)
                        ->wherehas('order', function($q)use($trs){
                            $q->where('warehouse', $trs->warehouse)
                            ->whereIn('status', ['opened', 'processed'])
                            ->where('processes->picked->is_executed', false);
                        })->sum('qty');
                    $stat->save();

                    $stock  = $stat->current_stock - $stat->onhold_stock;

                    if($stock > 0 && $stat->reserved_stock > $stock){
                        //KALAU STOK REBUTAN
                        $ods    = Order::wherehas('bills', function($q)use($stat){
                            $q->where('catalog_code', $stat->item->code);
                        })->where('warehouse', $trs->warehouse)->where('status', 'opened')
                        ->with(['bills', 'bill' => function($q)use($stat){$q->where('catalog_code', $stat->item->code);}])
                        ->get();

                        $uuids  = [];
                        $hists  = [];
                        foreach ($ods as $od) {
                            $uuids[]    = $od['uuid'];
                            $hists[$od['uuid']] = [
                                'title'         => $od['shipping']['name'].' ('.$od['shipping']['phone'].') <br/>'.$od['shipping']['address'],
                                'stake'         => $od->bill,
                                'compares'      => $od->bills,
                                'callback_url'  => route('tsale.transaction.show', ['marketplace' => $od['marketplace'], 'id' => $od['uuid']]),
                            ];
                        }

                        $cnfl   = AppConflict::where('code', $stat->item['code'])
                        ->where('topic', 'stock_overlap')
                        ->firstornew();

                        $cnfl->topic    = 'stock_overlap';
                        $cnfl->code     = $stat->item['code'];
                        $cnfl->stakes   = [
                            'issue'         => 'Rebutan '.$stat->current_stock.' stok '.$stat->item['name'],     
                            'label'         => $stat->item['name'],     
                            'callback_model'=> ItemStat::class,     
                            'callback_field'=> 'id',
                            'callback_value'=> $stat['id'],     
                            'callback_url'  => route('twh.item.show', $stat->item['uuid']),
                        ];
                        $cnfl->audiences = $uuids;
                        $cnfl->histories = $hists;
                        $cnfl->save();

                        foreach ($uuids as $uuid) {
                            $msg    = 'Stok '.$line['description'].' rebutan dengan pesanan lain. <a href="'.route('app.conflict.get', ['topic' => 'stock_overlap', 'filter[search]' => $line['catalog_code']]).'" target="__blank"> Cek konflik disini </a>';
                            $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)->persist();
                        }
                    }elseif($stock < $line['qty']) {
                        //KALAU STOK TIDAK CUKUO
                        $msg    = 'Stok '.($stock > 0 ? ' tinggal '.$stock : ' habis').' ('.$line['description'].')';
                        $chat   = TransactionAggregateRoot::retrieve($trs->uuid)->discuss($msg, $agent ? $agent : null)->persist();
                    }
                }
            }
        }

        return true;
    }

    private function conflict($trs, $when, $where){
        $agent      = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();

        if(!Str::is($trs->warehouse, 'dropship')){
            //CHECK OPEN CONFLICT
            $cnfls  = AppConflict::where('audiences', 'like', '%'.$trs->uuid.'%')
                ->where('topic', 'stock_overlap')
                ->get();

            foreach ($cnfls as $cnfl) {
                $item   = new $cnfl->stakes['callback_model'];
                $item   = $item->where($cnfl->stakes['callback_field'], $cnfl->stakes['callback_value'])->firstorfail();

                if(in_array($trs->status, ['voided'])) {
                    //0. KALAU TRANSAKSI DIVOID
                    // HIST DIHAPUS
                    $hists  = $cnfl->histories;
                    unset($hists[$trs->uuid]);
                    $cnfl->histories = $hists;

                    // UUID DIHAPUS
                    $cnfl->audiences = array_diff($cnfl->audiences, [$trs->uuid]);
                    $cnfl->save();

                    foreach ($cnfl->audiences as $uuid) {
                        $msg    = 'Transaksi nomor <a href="'.route('tsale.transaction.show', ['marketplace' => $trs->marketplace, 'id' => $trs->uuid]).'" target="__blank"> #'.($trs->no_ref ? $trs->no_ref : $trs->no).' di '.$trs->marketplace.' '.$trs->outlet.'</a> sudah membatalkan pesanan '.$cnfl->stakes['label'].' <a href="'.route('app.conflict.get', ['topic' => 'stock_overlap', 'filter[search]' => $item['code']]).'" target="__blank"> Cek konflik disini </a>';

                        if($item['reserved_stock'] > $item['current_stock']) {
                            $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)->persist();
                        }else{
                            $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)
                                ->discuss('CLOSED', $agent ? $agent : null)->persist();
                        }
                    }
                    if($item['reserved_stock'] <= $item['current_stock']) { 
                        $cnfl->delete();
                    }

                }elseif(!in_array($cnfl->code, array_column($trs->bills->toArray(), 'catalog_code'))) {
                    //1. KALAU PRODUKNYA SUDAH HAPUS
                    // HIST DIHAPUS
                    $hists  = $cnfl->histories;
                    unset($hists[$trs->uuid]);
                    $cnfl->histories = $hists;

                    // UUID DIHAPUS
                    $cnfl->audiences = array_diff($cnfl->audiences, [$trs->uuid]);
                    $cnfl->save();

                    $cnd   = Item::where('code', $cnfl['code'])->first();

                    foreach ($cnfl->audiences as $uuid) {
                        $msg    = 'Transaksi nomor <a href="'.route('tsale.transaction.show', ['marketplace' => $trs->marketplace, 'id' => $trs->uuid]).'" target="__blank"> #'.($trs->no_ref ? $trs->no_ref : $trs->no).' di '.$trs->marketplace.' '.$trs->outlet.'</a> sudah mengganti/menghapus item '.$cnfl['stakes']['label'].' <a href="'.route('app.conflict.get', ['topic' => 'stock_overlap', 'filter[search]' => $cnfl['code']]).'" target="__blank"> Cek konflik disini </a>';

                        if($cnd['reserved_stock'] > $cnd['current_stock']) {
                            $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)->persist();
                        }else{
                            $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)
                                ->discuss('CLOSED', $agent ? $agent : null)->persist();
                        }
                    }
                    if($cnd['reserved_stock'] <= $cnd['current_stock']) { 
                        $cnfl->delete();
                    }
                }else {
                    $hist   = $cnfl->histories[$trs->uuid];
                    $old    = collect($hist['compares'])->where('catalog_code', $cnfl->code)->sum('qty');
                    $new    = collect($trs->bills)->where('catalog_code', $cnfl->code)->sum('qty');
                    
                    if($old > $new) {
                        //2. KALAU PRODUKNYA SUDAH DIKURANGI DAN TIDAK CONFLICT
                        $uuids  = array_diff($cnfl->audiences, [$trs->uuid]);
                        foreach ($uuids as $uuid) {
                            $msg    = 'Transaksi nomor <a href="'.route('tsale.transaction.show', ['marketplace' => $trs->marketplace, 'id' => $trs->uuid]).'" target="__blank"> #'.($trs->no_ref ? $trs->no_ref : $trs->no).' di '.$trs->marketplace.' '.$trs->outlet.'</a> sudah mengubah permintaan pesanan item '.$item['name'].' menjadi '.$new.'. <a href="'.route('app.conflict.get', ['topic' => 'stock_overlap', 'filter[search]' => $cnfl['code']]).'" target="__blank"> Cek konflik disini </a>';

                           if($item['reserved_stock'] > $item['current_stock']) {
                                $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)->persist();
                            }else{
                                $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)
                                    ->discuss('CLOSED', $agent ? $agent : null)->persist();
                            }
                        }

                        if($item['reserved_stock'] <= $item['current_stock']) { 
                            $cnfl->delete();
                        }
                    }
                }
            }
        }else{
            //CHECK OPEN CONFLICT
            $cnfls  = AppConflict::where('audiences', 'like', '%'.$trs->uuid.'%')
                ->where('topic', 'stock_overlap')
                ->get();

            foreach ($cnfls as $cnfl) {
                //0. KALAU TRANSAKSI DIVOID
                // HIST DIHAPUS
                $hists  = $cnfl->histories;
                unset($hists[$trs->uuid]);
                $cnfl->histories = $hists;

                // UUID DIHAPUS
                $cnfl->audiences = array_diff($cnfl->audiences, [$trs->uuid]);
                $cnfl->save();

                $item   = new $cnfl->stakes['callback_model'];
                $item   = $item->where($cnfl->stakes['callback_field'], $cnfl->stakes['callback_value'])->firstorfail();

                foreach ($cnfl->audiences as $uuid) {
                    $msg    = 'Transaksi nomor <a href="'.route('tsale.transaction.show', ['marketplace' => $trs->marketplace, 'id' => $trs->uuid]).'" target="__blank"> #'.($trs->no_ref ? $trs->no_ref : $trs->no).' di '.$trs->marketplace.' '.$trs->outlet.'</a> sudah mengalihkan pesanan '.$item['name'].' untuk pengiriman dropship <a href="'.route('app.conflict.get', ['topic' => 'stock_overlap', 'filter[search]' => $item['code']]).'" target="__blank"> Cek konflik disini </a>';

                    if($item['reserved_stock'] > $item['current_stock']) {
                        $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)->persist();
                    }else{
                        $chat   = TransactionAggregateRoot::retrieve($uuid)->discuss($msg, $agent ? $agent : null)
                            ->discuss('CLOSED', $agent ? $agent : null)->persist();
                    }
                }

                if($item['reserved_stock'] <= $item['current_stock']) { 
                    $cnfl->delete();
                }
            }
        }

        return true;
    }

    private function ship_alert($trs, $when, $who){
        if(!Str::is('*grab*', $trs->courier) && !Str::is('*gojek*', $trs->courier) && empty($trs->shipping['receipt'])) {
            $agent  = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();
            $msg    = 'Belum ada nomor resi, pengiriman dengan ekspedisi harus menyertakan nomor resi';
            $chat   = TransactionAggregateRoot::retrieve($trs->uuid)->discuss($msg, $agent ? $agent : null)->persist();
        }

        return true;
    }

    private function print_alert($trs, $when, $who){
        if(!$trs->is_printed && $trs->has_printed_before && !config()->get('tsale.default.order.is_printed')){
            $agent  = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();
            $msg    = '#'.($trs->no_ref ? $trs->no_ref : $trs->no).' perlu re-print ';
            $chat   = TransactionAggregateRoot::retrieve($trs->uuid)->discuss($msg, $agent ? $agent : null)->persist();
        }

        return true;
    }

    private function auto_print($trs, $when, $who){
        if(!$trs->is_printed && $trs->can_print && config()->get('tsale.default.order.is_printed')){
            $print  = TransactionAggregateRoot::retrieve($trs->uuid)->print()->persist();
        }

        return true;
    }

    public function onCreated(Created $event, String $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);

        $this->generate_flow($trs, $event->when, $event->who);
        $this->stock_alert($trs, $event->when, $event->who);
        // $this->ship_alert($trs, $event->when, $event->who);
        // $this->print_alert($trs, $event->when, $event->who);
        // $this->auto_print($trs, $event->when, $event->who);
        $this->conflict($trs, $event->when, $event->who);
    }

    public function onUpdated(Updated $event, String $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);

        $this->stock_alert($trs, $event->when, $event->who);
        // $this->ship_alert($trs, $event->when, $event->who);
        // $this->print_alert($trs, $event->when, $event->who);
        // $this->auto_print($trs, $event->when, $event->who);
        $this->conflict($trs, $event->when, $event->who);
    }

    public function onAssigned(Assigned $event, string $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);

        $this->stock_alert($trs, $event->when, $event->who);
        // $this->ship_alert($trs, $event->when, $event->who);
        // $this->print_alert($trs, $event->when, $event->who);
        // $this->auto_print($trs, $event->when, $event->who);
        $this->conflict($trs, $event->when, $event->who);
    }

    public function onProcessed(Processed $event, String $aggregateUuid){
        //ON UPDATE, UPDATE DOKUMEN DI GUDANG
        $trs  = Order::uuid($aggregateUuid);

        $this->stock_alert($trs, $event->when, $event->who);

        if(Str::is('daily', config()->get('web.setting.wh_usage_cutoff'))) {
            $this->wh_usage_cutoff_daily($event, $trs);
        }else{
            $this->wh_usage_cutoff_transaction($event, $trs);
        }
    }

    public function onDiscussed(Discussed $event, String $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);
        $this->auto_print($trs, $event->when, $event->who);
        
        $us     = new User;
        $us     = $us->setConnection(config()->get('web.user.conn'));
        $us     = $us->whereIn('id', array_column($trs->chats->toArray(), 'user_id'))->wherenotnull('fcm_token')->get()->toarray();
        $us2    = Token::whereIn('user_id', array_column($trs->chats->toArray(), 'user_id'))->wherenotnull('fcm')->where('revoked', 0)->get()->toarray();
        $tokens = array_column($us, 'fcm_token');
        $tokens = array_filter(array_merge($tokens, array_column($us2, 'fcm')));

        // if(count($tokens)){
        //     $optionBuilder = new OptionsBuilder();
        //     $optionBuilder->setTimeToLive(60*20);
        //     // $optionBuilder->setRestrictedPackageName = 'id.thunderlab.kontenaTeam';
        //     $title  = substr($trs->chats[0]->user->name.': '.$event->attr, 0, 100);
        //     $title  = explode(' ', $title);
        //     array_pop($title); // remove last word from array
        //     $title  = implode(' ', $title);

        //     $notificationBuilder = new PayloadNotificationBuilder($title);
        //     $notificationBuilder->setBody($event->attr)
        //                         // ->setSound('default');
        //                         ->setSound('https://sgp1.digitaloceanspaces.com/basilhotel/kontena/audios/PanicButton.mp3');

        //     $dataBuilder = new PayloadDataBuilder();
        //     $dataBuilder->addData(['no' => $trs->no_ref]);

        //     $option = $optionBuilder->build();
        //     $notification = $notificationBuilder->build();
        //     $data = $dataBuilder->build();

        //     $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        //     $downstreamResponse->numberSuccess();
        //     $downstreamResponse->numberFailure();
        //     $downstreamResponse->numberModification();

        //     // return Array - you must remove all this tokens in your database
        //     $downstreamResponse->tokensToDelete();

        //     // return Array (key : oldToken, value : new token - you must change the token in your database)
        //     $downstreamResponse->tokensToModify();

        //     // return Array - you should try to resend the message to the tokens in the array
        //     $downstreamResponse->tokensToRetry();

        //     // return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        //     $downstreamResponse->tokensWithError();
        // }
    }

    public function onClosed(Closed $event, string $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);
        //BYPASS
        $doc    = Document::where('no_ref', $trs->no)->wherenotin('status', ['locked'])->first();
        if($doc) {
            $doc= DocumentAggregateRoot::retrieve($doc->uuid)->archive([])->persist();
        }
        //BUAT TRANSAKSI JURNAL
        $boo  = Book::where('no_ref', $trs->no)->firstornew();
        $doc  = [
            'no_ref'    => $trs->no,
            'cause'     => 'transaksi',
            'group'     => $trs->marketplace,
            'type'      => 'nota_penjualan',
            'date'      => $trs->issued_at,
            // 'lines'     => $trs->bills,
            'lines'     => array_merge($trs->bills->toArray(), $trs->payments->toArray()),
            'issuer'    => [
                'name'      => $trs->store['name'],
                'phone'     => $trs->store['phone'],
                'address'   => $trs->store['address']
            ],
            'customer'  => [
                'pid'       => '',
                'name'      => $trs->shipping['name'],
                'phone'     => $trs->shipping['phone'],
                'address'   => $trs->shipping['address']
            ],
        ];

        // $jrns   = [];
        // foreach ($doc->payments as $pay) {
        //     $coa= Coa::search($pay['method'])->first();
        //     if($coa) {
        //         $jrns[]     = [
        //             'coa_id'        => $coa->id,
        //             'coa_code'      => $coa->code,
        //             'no_ref'        => $pay['no_ref'],
        //             'description'   => $pay['description'],
        //             'amount'        => $pay['amount'],
        //         ];
        //     }
        // }

        //1. BUAT PROJECTOR
        if($boo->id){
            $id = $boo->uuid;
        }else{
            $id =  (string) Uuid::uuid4();
        }
        $data   = BookAggregateRoot::retrieve($id)->draft($doc, [])->persist();
        // $data   = BookAggregateRoot::retrieve($id)->draft($doc, [])->journal($jrns)->persist();
    }

    public function onVoided(Voided $event, string $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);
        $doc    = Document::where('no_ref', $trs->no)->first();
        if($doc) {
            $doc= DocumentAggregateRoot::retrieve($doc->uuid)->archive([])->persist();
        }
        $this->conflict($trs, $event->when, $event->who);
    }
}