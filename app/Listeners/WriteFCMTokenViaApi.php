<?php

namespace App\Listeners;

use App\User;
use Laravel\Passport\Token;
use Laravel\Passport\Events\AccessTokenCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WriteFCMTokenViaApi
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
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handle(AccessTokenCreated $event) {
        //TULIS LAST SEEN
        $user       = User::findorfail($event->userId);
        $user->last_seen_at      = now();
        $user->save();

        //TULIS FCM TOKEN
        if(request()->has('fcm_token')) {
            $token          = Token::findorfail($event->tokenId);
            $token->fcm     = request()->get('fcm_token');
            $token->save();
        }
    }
}
