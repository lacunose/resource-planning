<?php

namespace Lacunose\Customer\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Unprogrammed extends ShouldBeStored {
   /** @var array */
    public $ids;

    public function __construct(array $ids) {
        $this->ids 	= $ids;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->when	= now();
    }
}
