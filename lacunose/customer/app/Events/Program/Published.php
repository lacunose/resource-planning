<?php

namespace Lacunose\Customer\Events\Program;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Published extends ShouldBeStored {
   /** @var string */
    public $from;

   /** @var string */
    public $to;

    public function __construct(string $from, string $to = null) {
        $this->from = $from;
        $this->to 	= $to;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->what	= ['from' => $from, 'to' => $to];
        $this->when	= now();
    }
}
