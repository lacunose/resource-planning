<?php

namespace Lacunose\Customer\Aggregates;

use Auth, Carbon\Carbon, Str, Validator;

use Lacunose\Customer\Events\Account\Opened;
use Lacunose\Customer\Events\Account\Issued;
use Lacunose\Customer\Events\Account\Verified;
use Lacunose\Customer\Events\Account\Closed;

use Lacunose\Customer\Models\Account;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use Illuminate\Validation\ValidationException;

class AccountAggregateRoot extends AggregateRoot
{
    protected $editable     = true;
    protected $deletable    = true;

    public function __construct() {
        if ( Str::is('tenant', config()->get('tswirl.db.tcust')) ) {
            config(['database.default' => 'tenant']);
        }
    }

    public function open(array $attr) {
        $this->recordThat(new Opened($attr))->persist();
        
        return $this;
    }

    public function issue(array $attr) {
        $this->recordThat(new Issued($attr))->persist();
        
        return $this;
    }

    public function verify(array $nos) {
        $this->recordThat(new Verified($nos))->persist();
        
        return $this;
    }

    public function close() {
        $this->recordThat(new Closed())->persist();
        
        return $this;
    }
}
