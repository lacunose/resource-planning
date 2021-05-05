<?php

namespace Lacunose\Customer\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Inactivated extends ShouldBeStored {
   /** @var string */
    public $status;

    public function __construct(string $status = 'inactived') {
        $this->status = $status;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->when	= now();
    }
}
