<?php

namespace App\Reactors;

use Mail;
use Ramsey\Uuid\Uuid;

use App\User;

use Lacunose\Acl\Events\User\VerificationTokenRequested;

use Lacunose\Subscribe\Mail\SendNotification;

use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;
/*----------  Events  ----------*/
final class UserReactor extends Reactor {

    public function onVerificationTokenRequested(VerificationTokenRequested $event, String $aggregateUuid) {
        $user = User::where('uuid', $aggregateUuid)->firstorfail();
        Mail::to($user->email)->send(new SendNotification([
            'user'          => $user->toArray(), 
            'sender'        => config()->get('tacl'), 
            'title'         => 'Seseorang telah mendaftar dengan email Anda sebagai pengguna '.env('APP_NAME'), 
            'description'   => 'Silahkan klik link berikut untuk verifikasi akun Anda', 
            'url'           => route('verified', [$user->uuid, $event->token])
        ]));
    }
}