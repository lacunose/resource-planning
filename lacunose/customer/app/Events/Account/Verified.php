<?php

namespace Lacunose\Customer\Events\Account;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Verified extends ShouldBeStored {
   /** @var array */
    public $nos;

    public function __construct(array $nos) {
        $this->nos 	= $nos;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->what	= $nos;
        $this->when	= now();
    }
}
