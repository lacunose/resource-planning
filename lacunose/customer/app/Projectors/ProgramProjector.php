<?php

namespace Lacunose\Customer\Projectors;

use Arr, Auth, DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

use Lacunose\Customer\Models\Program;

use Lacunose\Customer\Events\Program\Saved;
use Lacunose\Customer\Events\Program\Published;
use Lacunose\Customer\Events\Program\Unpublished;
use Lacunose\Customer\Events\Program\Deleted;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Illuminate\Validation\ValidationException;

final class ProgramProjector extends Projector{

    public function onSaved(Saved $event, string $aggregateUuid){
        $pack   = program::firstornew(['uuid' => $aggregateUuid]);
        $pack->fill($event->attr);
        $pack->save();
    }

    public function onPublished(Published $event, string $aggregateUuid){        
        $pack   = program::uuid($aggregateUuid);
        $pack->published_at      = $event->from;
        $pack->published_until   = $event->to;
        $pack->save();
    }

    public function onUnpublished(Unpublished $event, string $aggregateUuid){        
        $pack   = program::uuid($aggregateUuid);
        $pack->published_until   = $event->to;
        $pack->save();
    }
    public function onDeleted(Deleted $event, string $aggregateUuid){
        program::uuid($aggregateUuid)->delete();
    }
}
