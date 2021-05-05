<?php

namespace Lacunose\Customer\Events\Program;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Saved extends ShouldBeStored {
   /** @var array */
    public $attr;

    public function __construct(array $attr) {
        $this->attr = $attr;
        $this->who 	= auth()->check() ? auth()->user() : null;
        $this->what	= $attr;
        $this->when	= now();
    }
}
