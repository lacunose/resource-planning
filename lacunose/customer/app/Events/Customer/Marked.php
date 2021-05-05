<?php

namespace Lacunose\Customer\Events\Customer;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Marked extends ShouldBeStored {
   /** @var array */
    public $attr;

    public function __construct(array $attr)
    {
        $this->attr 	= $attr;
        $this->who		= auth()->check() ? auth()->user() : null;
        $this->what		= $attr;
        $this->when		= now();
    }
}
