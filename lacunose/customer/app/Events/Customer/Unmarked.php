<?php

namespace Lacunose\Customer\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Unmarked extends ShouldBeStored {
   /** @var array */
    public $id;

    public function __construct(int $id) {
        $this->id 	= $id;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->when	= now();
    }
}
