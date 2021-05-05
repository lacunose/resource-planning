<?php

namespace Lacunose\Customer\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Deleted extends ShouldBeStored {
    public function __construct() {
    	$this->who 	= auth()->check() ? auth()->user() : null;
        $this->when	= now();
    }
}
