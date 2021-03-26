<?php

namespace App\Reactors;

use Str, Storage, DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

use App\User;
use App\AppConflict;

use Lacunose\Procure\Models\Order;
use Lacunose\Procure\Models\OrderBill;

use Lacunose\Warehouse\Models\Item;
use Lacunose\Warehouse\Models\ItemStat;
use Lacunose\Warehouse\Models\Report;
use Lacunose\Warehouse\Models\Document;

use Lacunose\Finance\Models\Book;

use Lacunose\Procure\Aggregates\TransactionAggregateRoot;
use Lacunose\Warehouse\Aggregates\DocumentAggregateRoot;
use Lacunose\Finance\Aggregates\BookAggregateRoot;

/*----------  Events  ----------*/
use Lacunose\Procure\Events\Transaction\Created;
use Lacunose\Procure\Events\Transaction\Updated;
use Lacunose\Procure\Events\Transaction\Received;
use Lacunose\Procure\Events\Transaction\Processed;
use Lacunose\Procure\Events\Transaction\Closed;
use Lacunose\Procure\Events\Transaction\Voided;

final class ProcureTransactionReactor extends Reactor {

    private function incoming_stock($trs, $when, $who){
        $agent = (new User)->setConnection(config()->get('web.user.conn'))->where('email', config()->get('web.agent.chatbot'))->first();

        if(!Str::is($trs->warehouse, 'dropship')){

            $lines  = $trs->bills()->where('item_code', '!=', NULL)->get();

            foreach ($lines as $line) {
                $item   = Item::where('code', $line->item_code)->firstorfail();
                $stat   = ItemStat::where('item_id', $item->id)->where('warehouse', $trs->warehouse)->firstornew();
                $ic     = OrderBill::where('item_code', $item->code)
                    ->wherehas('order', function($q)use($trs){
                        $q->where('warehouse', $trs->warehouse)
                        ->whereIn('status', ['opened', 'processed', 'closed']);
                    })->sum(DB::raw('qty - rcv'));

                $stat->item_id          = $item->id;
                $stat->warehouse        = $trs->warehouse;
                $stat->incoming_stock   = max(0, $ic);
                $stat->save();
            }
        }

        return true;
    }

    public function onReceived(Received $event, String $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);
        $this->incoming_stock($trs, $event->when, $event->who);
    }

    public function onVoided(Voided $event, String $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);
        $this->incoming_stock($trs, $event->when, $event->who);
    }

    public function onProcessed(Processed $event, String $aggregateUuid){
        $trs  = Order::uuid($aggregateUuid);
        $this->incoming_stock($trs, $event->when, $event->who);

        $ono    = $trs->no;
        $doc    = Document::where('no_ref', $ono)->first();
        
        if(!Str::is($trs->warehouse, 'dropship') && !$doc){

            $lines      = [];
            $stocks     = [];

            foreach ($trs->bills as $line) {
                if($line['item_code']){
                    $item       = Item::where('code', $line['item_code'])->first();
                    $lines[]    = [
                        'item_code'     => $item ? $item->code : $line['item_code'], 
                        'description'   => $item ? $item->name : $line['description'], 
                        'amount'        => $line['qty']
                    ];

                    if($item){
                        $stocks[]   = [
                            'item_id'       => $item ? $item->id : null,
                            'item_code'     => $item ? $item->code : null,
                            'batch'         => null, 
                            'owner'         => null, 
                            'expired_at'    => null, 
                            'description'   => $item ? $item->name : $line['description'], 
                            'amount'        => $line['qty'] * -1
                        ];
                    }
                }
            }

            if(Str::is('konsinyasi', $trs->mode)) {
                $owner  = $trs->supplier;
            }else{
                $owner  = $trs->user->sub->website;
            }

            $uuid       =  (string) Uuid::uuid4();
            if($doc){
                $uuid   = $doc->uuid;
            }

            $doc        = DocumentAggregateRoot::retrieve($uuid)->draft([
                'id'        => 0,
                'no_ref'    => $ono,
                'title'     => 'Receiving #'.$trs->no,
                'cause'     => 'masuk',
                'owner'     => $owner,
                'warehouse' => $trs->warehouse,
                'type'      => 'receiving',
                'date'      => $event->when->format('Y-m-d H:i:s'),
                'status'    => 'drafted',
                'lines'     => $lines,
                'sender'    => [
                    'name'   => $trs->sender['name'],
                    'phone'  => $trs->sender['phone'],
                    'address'=> $trs->sender['address'],
                    'receipt'=> null,
                    'courier'=> null,
                ],
                'receiver'   => [
                    'name'   => null,
                    'phone'  => null,
                    'address'=> null,
                ],
                'requested_at'  => $trs->issued_at->format('Y-m-d H:i:s'),
            ], [])->persist();
        }elseif(Str::is($trs->warehouse, 'dropship') && $doc){
            $doc    = DocumentAggregateRoot::retrieve($doc->uuid)->archive([])->persist();
        }
    }
}