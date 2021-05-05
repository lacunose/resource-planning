<?php

namespace Lacunose\Customer\Events\Account;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Auth;

class Opened extends ShouldBeStored {
   /** @var array */
    public $attr;

   /** @var string */
    public $status;

    public function __construct(array $attr, string $status = 'opened') {
        $this->attr 	= $attr;
        $this->status 	= $status;
        $this->who 		= auth()->check() ? auth()->user() : null;
        $this->what		= $attr;
        $this->when		= now();
    }
}
