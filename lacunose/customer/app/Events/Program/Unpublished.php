<?php

namespace Lacunose\Customer\Events\Program;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Unpublished extends ShouldBeStored {
   /** @var string */
    public $to;

    public function __construct(string $to = null) {
        $this->to 	= $to;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->what	= $to;
        $this->when	= now();
    }
}
