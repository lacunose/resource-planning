<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteFCMTokenViaWeb
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event) {
        $event->user->last_seen_at      = now();
        if(request()->has('fcm_token')){
            $event->user->fcm_token     = request()->get('fcm_token');
        }
        $event->user->save();
    }
}
