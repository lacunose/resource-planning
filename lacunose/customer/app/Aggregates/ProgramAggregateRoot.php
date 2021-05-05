<?php

namespace Lacunose\Customer\Aggregates;

use Auth, Carbon\Carbon, Str, Validator;

use Lacunose\Customer\Models\Program;

use Lacunose\Customer\Events\Program\Saved;
use Lacunose\Customer\Events\Program\Published;
use Lacunose\Customer\Events\Program\Unpublished;
use Lacunose\Customer\Events\Program\Deleted;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Illuminate\Validation\ValidationException;

class ProgramAggregateRoot extends AggregateRoot {
    protected $editable     = true;
    protected $deletable    = true;

    public function __construct() {
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            config(['database.default' => 'tenant']);
        }
    }

	public function save(array $attr) {
        $this->recordThat(new Saved($attr))->persist();
        
        return $this;
    }

    public function publish(string $from = null, string $to = null) {
        $this->recordThat(new Published($from, $to))->persist();
        
        return $this;
    }

    public function unpublish(string $to = null) {
        $this->recordThat(new Unpublished($to))->persist();
        
        return $this;
    }

    public function delete() {
        $this->recordThat(new Deleted())->persist();
        
        return $this;
    }
}
