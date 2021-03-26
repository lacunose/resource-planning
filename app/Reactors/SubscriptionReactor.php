<?php

namespace App\Reactors;

use Str, Mail, Storage;
use Ramsey\Uuid\Uuid;

use App\User;
use Lacunose\Acl\Models\Endpoint;
use Lacunose\Acl\Models\Access;
use Lacunose\Subscribe\Models\Plan;

use Lacunose\Subscribe\Events\Subscription\Updated;
use Lacunose\Subscribe\Events\Subscription\Paid;

use Lacunose\Acl\Aggregates\UserAggregateRoot;
use Lacunose\Acl\Aggregates\EndpointAggregateRoot;
use Lacunose\Acl\Aggregates\AccessAggregateRoot;
use Lacunose\Acl\Mail\SendConfirmation;

use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

/*----------  Tenancy  ----------*/
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

/*----------  Events  ----------*/
final class SubscriptionReactor extends Reactor {
    public function onUpdated(Updated $event, string $aggregateUuid){
        //1. CHANGE ROLE TO OWNER
        $plan       = Plan::uuid($aggregateUuid);
        if(Str::is($plan->user->level, 'member')){
            $data   = UserAggregateRoot::retrieve($plan->user->uuid)->update([
                'level' => 'owner',
                'scopes'=>  $plan->user->scopes,
            ])->persist();
        }

        //NYALAKAN SUBS
        $hostname   = Hostname::where('fqdn', $plan->website)->first();
        if($hostname && $hostname->under_maintenance_since->lt($plan->ended_at)) {
            $hostname->under_maintenance_since  = $plan->ended_at;
            $hostname   = app(HostnameRepository::class)->update($hostname);
        }
    }

    public function onPaid(Paid $event, string $aggregateUuid){
        $plan   = Plan::uuid($aggregateUuid);
        if($plan->nth == 1){
            //1. CREATE TENANT 
            /*----------  Create Website  ----------*/
            $website = new Website;
            app(WebsiteRepository::class)->create($website);

            /*----------  Link Website to Hostname  ----------*/
            $hostname = new Hostname;
            $hostname->fqdn = $plan->website;
            $hostname->under_maintenance_since  = $plan->ended_at;
            $hostname = app(HostnameRepository::class)->create($hostname);
            app(HostnameRepository::class)->attach($hostname, $website);

            //2. AUTO CREATE ENDPOINT
            $endp     = Endpoint::where('website', $plan->website)->first();
            if(!$endp) {
                $uuid = (string) Uuid::uuid4(); 
                $dt   = EndpointAggregateRoot::retrieve($uuid)->save([
                    'website'   => $plan->website, 
                    'roles'     => array_keys(config()->get('tacl.opsi.role')), 
                    'name'      => $plan->biller['business'], 
                    'phone'     => $plan->biller['phone'], 
                    'address'   => $plan->biller['address'], 
                ])->persist();
            }
            $endp     = Endpoint::where('website', $plan->website)->first();

            //3. AUTO CREATE ENDPOINT
            $acc      = Access::where('website', $plan->website)->where('email', $plan->user->email)->first();
            if(!$acc) {
                $uuid = (string) Uuid::uuid4(); 
                $dt   = AccessAggregateRoot::retrieve($uuid)->grant([
                    'website'       => $plan->website, 
                    'email'         => $plan->user->email, 
                    'role'          => 'owner', 
                    'scopes'        => $plan->scopes, 
                    'clients'       => $plan->clients, 
                    'endpoints'     => [$endp->id],
                ], $plan->ux_website)->acceptWithoutToken($plan->user->email)->persist();
            }

            //4. SETTING NGINX
            if(!Str::is('*.'.env('APP_BASE', 'localhost'), $plan->website)){
                //BUAT CONFIG .SH
                $template = Storage::get('sh/sites.conf');
                $template = str_replace('sitesname', $plan->website, $template);
                $filename = '/etc/nginx/sites-enabled/'.$plan->website;

                if(! file_exists( $filename ) ){
                  file_put_contents( $filename , $template);
                }

                // KIRIM EMAIL
                Mail::to($plan->user['email'])->send(new SendConfirmation([
                    'user'          => $plan->user, 
                    'title'         => 'Arahkan domain Anda ke IP '.env('APP_NAME'), 
                    'description'   => 'Silahkan arahkan domain '.$plan->Website.' Anda ke IP berikut', 
                    'token'         => env('APP_IP'),
                ]));
            }
        }else{
            //NYALAKAN SUBS
            $hostname   = Hostname::where('fqdn', $plan->website)->firstorfail();
            $hostname->under_maintenance_since  = $plan->ended_at;
            $hostname   = app(HostnameRepository::class)->update($hostname);
        }
    }
}