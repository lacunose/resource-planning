<?php

namespace Lacunose\Customer\Projectors;

use Arr, Auth, DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use Lacunose\Customer\Models\Customer;
use Lacunose\Customer\Models\CustomerMark;

use Lacunose\Customer\Events\Customer\Updated;
use Lacunose\Customer\Events\Customer\Activated;
use Lacunose\Customer\Events\Customer\Programmed;
use Lacunose\Customer\Events\Customer\Unprogrammed;
use Lacunose\Customer\Events\Customer\Inactivated;
use Lacunose\Customer\Events\Customer\Marked;
use Lacunose\Customer\Events\Customer\Unmarked;
use Lacunose\Customer\Events\Customer\Deleted;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

final class CustomerProjector extends Projector {

    public function onUpdated(Updated $event, string $aggregateUuid) {
        $cust   = Customer::firstornew(['uuid' => $aggregateUuid]);
        $cust->fill($event->attr);
        $cust->save();
    }

    public function onActivated(Activated $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
        if(is_null($cust->code)) {
            $cust->code     = $cust->phone;
        }
        $cust->status       = $event->status;
        $cust->save();
    }

    public function onProgrammed(Programmed $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
        $cust->programs()->attach($event->ids);
        $cust->save();
    }

    public function onUnprogrammed(Unprogrammed $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
        $cust->programs()->detach($event->ids);
        $cust->save();
    }

    public function onMarked(Marked $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
        $mark   = $cust->marks()->where('type', $event->attr['type'])->where('catalog_code', $event->attr['catalog_code'])->first();
        if(!$mark) {
            $mark   = new CustomerMark;
        }
        $mark->fill($event->attr);
        $mark->customer_id  = $cust->id;
        $mark->save();
    }

    public function onUnmarked(Unmarked $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
        $mark   = $cust->marks()->where('id', $event->id)->delete();
    }

    public function onInactivated(Inactivated $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
        $cust->status      = $event->status;
        $cust->save();
    }

    public function onDeleted(Deleted $event, string $aggregateUuid) {
        $cust   = Customer::uuid($aggregateUuid);
    }
}
