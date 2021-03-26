<?php

namespace App\Reactors;

use Str, Storage;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;
use Lacunose\Sale\Models\Order as SaleOrder;
use Lacunose\Procure\Models\Order as ProcureOrder;
use Lacunose\Finance\Models\Book;
use Lacunose\Warehouse\Models\Document;
use Lacunose\Warehouse\Models\Stock;

use Lacunose\Finance\Aggregates\BookAggregateRoot;
use Lacunose\Sale\Aggregates\TransactionAggregateRoot as SaleTransactionAggregateRoot;
use Lacunose\Procure\Aggregates\TransactionAggregateRoot as ProcureTransactionAggregateRoot;
use Lacunose\Warehouse\Aggregates\DocumentAggregateRoot;

/*----------  Events  ----------*/
use Lacunose\Warehouse\Events\Document\Stocked;
use Lacunose\Warehouse\Events\Document\Timed;
use Lacunose\Warehouse\Events\Document\Submitted;
use Lacunose\Warehouse\Events\Document\Locked;

use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

final class DocumentReactor extends Reactor {

    public function onStocked(Stocked $event, string $aggregateUuid){
        $agent  = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();
        $dwh    = Document::uuid($aggregateUuid);
        
        if(in_array($dwh->cause, ['keluar'])) {
            $order  = SaleOrder::no($dwh->no_ref)->first();
            if($order) {
                $msg= 'Paket sudah siap disiapkan oleh bagian gudang';
                $dt = SaleTransactionAggregateRoot::retrieve($order->uuid)->discuss($msg, $agent ? $agent : null)
                    ->process('picked')
                    ->discuss('CLOSED', $agent ? $agent : null)->persist();
            }
        }

        if(in_array($dwh->cause, ['masuk'])) {
            $order  = ProcureOrder::no($dwh->no_ref)->first();
            if($order) {
                $rs = [];
                foreach ($order->bills->where('item_code', '!=', NULL) as $line) {
                    $sts    = Stock::wherehas('document', function($q) use($dwh) {
                        $q->no($dwh->no_ref)->where('cause', 'masuk');
                    })->wherehas('item', function($q) use($line) {
                        $q->where('code', $line->item_code);
                    })->sum('amount');
                    $rs[]   = ['item_code' => $line->item_code, 'rcv' => $sts];
                    
                    $ud     = Stock::wherehas('document', function($q) use($dwh) {
                        $q->no($dwh->no_ref)->where('cause', 'masuk');
                    })->wherehas('item', function($q) use($line) {
                        $q->where('code', $line->item_code);
                    })->update(['price' => $line->amount]);
                }

                $dt = ProcureTransactionAggregateRoot::retrieve($order->uuid)
                    ->receive($rs)
                    ->persist();
            }
        }
    }

    public function onTimed(Timed $event, string $aggregateUuid){
        $agent  = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();
        $dwh    = Document::uuid($aggregateUuid);
        
        if(in_array($dwh->cause, ['keluar']) && Str::is($dwh->status, 'stocked') && !$dwh->ux_has_open_timer) {
            $order  = SaleOrder::no($dwh->no_ref)->first();
            if($order) {
                $msg= 'Paket sudah siap dipacking oleh bagian gudang';
                $dt = SaleTransactionAggregateRoot::retrieve($order->uuid)->discuss($msg, $agent ? $agent : null)
                    ->process('packed')
                    ->discuss('CLOSED', $agent ? $agent : null)->persist();
            }
        }
    }

    public function onSubmitted(Submitted $event, string $aggregateUuid){
        $agent  = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();
        $dwh    = Document::uuid($aggregateUuid);
        
        if(in_array($dwh->cause, ['keluar'])) {
            $order  = SaleOrder::no($dwh->no_ref)->first();
            if($order) {
                $msg= 'Paket sudah siap diserahterimakan ke bagian pengiriman';
                $dt = SaleTransactionAggregateRoot::retrieve($order->uuid)->discuss($msg, $agent ? $agent : null)
                    ->process('overhandled')
                    ->discuss('CLOSED', $agent ? $agent : null)->persist();
            }
        }
    }

    public function onLocked(Locked $event, string $aggregateUuid){
        $agent  = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();
        $dwh    = Document::uuid($aggregateUuid);
        
        if(in_array($dwh->cause, ['keluar'])) {
            $order  = SaleOrder::no($dwh->no_ref)->first();
            if($order) {
                $msg= 'Paket sudah diambil oleh ekspedisi / pelanggan';
                $dt = SaleTransactionAggregateRoot::retrieve($order->uuid)->discuss($msg, $agent ? $agent : null)
                    ->process('shipped')
                    ->discuss('CLOSED', $agent ? $agent : null)->persist();
            }
        }

        if(in_array($dwh->cause, ['masuk', 'keluar'])) {
            $lines      = [];

            foreach ($dwh->stocks as $line) {
                $lines[]    = [
                    'description'   => $line['description']. ' x '. $line['amount'], 
                    'amount'        => $line['amount'] * $line['price']
                ];
            }

            //BUAT TRANSAKSI JURNAL
            $boo  = Book::where('no_ref', $dwh->no)->firstornew();
            $doc  = [
                'no_ref'    => $dwh->no,
                'cause'     => config()->get('web.translator.tfin_twh_cause.'.$dwh->cause),
                'group'     => $dwh->warehouse,
                'type'      => config()->get('web.translator.tfin_twh_type.'.$dwh->cause),
                'date'      => $dwh->date,
                'lines'     => $lines,
                'issuer'    => [
                    'name'      => $dwh->sender['name'],
                    'phone'     => $dwh->sender['phone'],
                    'address'   => $dwh->sender['address']
                ],
                'customer'  => [
                    'pid'       => '',
                    'name'      => $dwh->receiver['name'],
                    'phone'     => $dwh->receiver['phone'],
                    'address'   => $dwh->receiver['address']
                ],
            ];

            //1. BUAT PROJECTOR
            if($boo->id){
                $id = $boo->uuid;
            }else{
                $id =  (string) Uuid::uuid4();
            }
            $data   = BookAggregateRoot::retrieve($id)->draft($doc, [])->persist();
        }
    }
}