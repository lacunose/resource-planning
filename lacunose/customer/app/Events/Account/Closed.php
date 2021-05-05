<?php

namespace Lacunose\Customer\Events\Account;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Closed extends ShouldBeStored {
   /** @var string */
    public $status;

    public function __construct(string $status = 'closed') {
        $this->status 	= $status;
        $this->who 		= auth()->check() ? auth()->user() : null;
        $this->when		= now();
    }
}
