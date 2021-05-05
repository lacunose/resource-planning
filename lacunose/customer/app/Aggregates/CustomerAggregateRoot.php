<?php

namespace Lacunose\Customer\Aggregates;

use Auth, Carbon\Carbon, Str, Validator;

use Lacunose\Customer\Events\Customer\Updated;
use Lacunose\Customer\Events\Customer\Activated;
use Lacunose\Customer\Events\Customer\Programmed;
use Lacunose\Customer\Events\Customer\Unprogrammed;
use Lacunose\Customer\Events\Customer\Inactivated;
use Lacunose\Customer\Events\Customer\Marked;
use Lacunose\Customer\Events\Customer\Unmarked;
use Lacunose\Customer\Events\Customer\Deleted;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CustomerAggregateRoot extends AggregateRoot {
    protected $editable     = true;
    protected $deletable    = true;
    
    protected static bool $allowConcurrency = true;

    public function __construct() {
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            config(['database.default' => 'tenant']);
        }
    }
    
    public function update(array $attr) {
        $this->recordThat(new Updated($attr))->persist();
        
        return $this;
    }

    public function activate() {
        $this->recordThat(new Activated())->persist();
        
        return $this;
    }

    public function inactivate() {
        $this->recordThat(new Inactivated())->persist();
        
        return $this;
    }

    public function program(array $ids) {
        $this->recordThat(new Programmed($ids))->persist();
        
        return $this;
    }

    public function unprogram(array $ids) {
        $this->recordThat(new Unprogrammed($ids))->persist();
        
        return $this;
    }

    public function mark(array $mark) {
        $this->recordThat(new Marked($mark))->persist();
        
        return $this;
    }

    public function unmark(int $id) {
        $this->recordThat(new Unmarked($id))->persist();
        
        return $this;
    }

    public function delete() {
        $this->recordThat(new Deleted())->persist();
        
        return $this;
    }
}
