<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Validator, Auth, Exception, Log, Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

use App\User;

use Lacunose\Acl\Models\Access;
use Lacunose\Acl\Models\Endpoint;
use Lacunose\Acl\Aggregates\UserAggregateRoot;
use Lacunose\Acl\Aggregates\AccessAggregateRoot;
use Lacunose\Acl\Aggregates\EndpointAggregateRoot;

class NakoaV1SyncAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nakoa:sync:access';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data user dari nakoa versi 1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Auth::loginUsingId(2);

        // $website    = 'nakoa.localhost';
        $website     = 'basilx.nakoa.id';

        $blists     = [];
            
        $this->set_endpoint($website);

        $this->set_thunder_user($website, 'chelsy@thunderlab.id');
        
        $this->set_user_from_employment($website, $blists);
    }

    private function set_endpoint($website) {
        $inp1  = [
            'website'   => $website,
            'roles'     => array_keys(config()->get('tacl.opsi.role')),
            'name'      => 'MLG01',
            'phone'     => '',
            'address'   => 'Jl Bondowoso 14, KOTA MALANG JAWA TIMUR, INDONESIA',
        ];

        $inp2  = [
            'website'   => $website,
            'roles'     => array_keys(config()->get('tacl.opsi.role')),
            'name'      => 'MLG02',
            'phone'     => '',
            'address'   => 'Jl MT Haryono 116, KOTA MALANG JAWA TIMUR, INDONESIA',
        ];
        
        $dt1    = Endpoint::where('website', $website)->where('name', $inp1['name'])->first();
        $dt2    = Endpoint::where('website', $website)->where('name', $inp2['name'])->first();
        $id1    = $dt1 ? $dt1->uuid : (string) Uuid::uuid4();
        $id2    = $dt2 ? $dt2->uuid : (string) Uuid::uuid4();
        
        try {
            DB::BeginTransaction();
            //1. STORE USER
            $dt = EndpointAggregateRoot::retrieve($id1)->save($inp1)->persist();
            $dt = EndpointAggregateRoot::retrieve($id2)->save($inp2)->persist();
            //2. GRANT AKSES

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::info('TROUBLE: '.$e);
        }
    }

    private function set_thunder_user($website, $email) {
        $domains    = config()->get('tsub.support.scopes');
        $role       = 'maintainer';
        $scopes     = [];

        foreach ($domains as $dom) {
            $scopes = array_merge(array_keys(config()->get($dom.'.scopes')), $scopes);
        }
        
        $acc    = Access::where('website', $website)->where('email', $email)->first();

        $inp2   = [
            'website'   => $website,
            'email'     => $email,
            'token'     => Str::random(32),
            'role'      => $role,
            'scopes'    => $scopes,
            'clients'   => array_keys(config()->get('tsub.opsi.client')),
            'endpoints' => array_column(Endpoint::whereIn('name', ['MLG01', 'MLG02'])->get()->toArray(), 'id'),
        ];

        try{
            $id2= $acc ? $acc->uuid : (string) Uuid::uuid4();
            $dt = AccessAggregateRoot::retrieve($id2)->grant($inp2, 'https://basil.id')->accept($inp2['token'])->persist();
        } catch (Exception $e) {
            DB::rollback();
            Log::info('TROUBLE: '.$e);
        }
    }

    private function set_user_from_employment($website, $blists){
        $users  = DB::connection('nakoa1')->table('USER_users')->get();
        foreach ($users as $user) {
            $nuser  = User::where('phone', $user->username)->first();
            $email  = $user->username.'@nakoa.id';
            if(!$nuser && !in_array($email, $blists)) {
                $acc    = Access::where('website', $website)->where('email', $email)->first();

                $domains    = ['tsale', 'twh', 'tmf'];
                $scopes     = [];
                $role       = 'staff';

                if($user->management_roles && in_array('finance', json_decode($user->management_roles, true))) {
                    $domains    = ['tproc', 'tfin'];
                    $role       = 'accountant';
                }elseif($user->management_roles && in_array('superuser', json_decode($user->management_roles, true))) {
                    $domains    = config()->get('tsub.support.scopes');
                    $role       = 'owner';
                }

                foreach ($domains as $dom) {
                    $scopes     = array_merge(array_keys(config()->get($dom.'.scopes')), $scopes);
                }

                $inp1   = [
                    'name'      => $user->name,
                    'email'     => $email,
                    'phone'     => $user->username,
                    'level'     => 'member',
                    'scopes'    => [],
                    'password'  => $user->password,
                ];

                $inp2   = [
                    'website'   => $website,
                    'email'     => $email,
                    'token'     => Str::random(32),
                    'role'      => $role,
                    'scopes'    => $scopes,
                    'clients'   => array_keys(config()->get('tsub.opsi.client')),
                    'endpoints' => array_column(Endpoint::whereIn('name', ['MLG01', 'MLG02'])->get()->toArray(), 'id'),
                ];

                $id = $nuser ? $nuser->uuid : (string) Uuid::uuid4();
                $id2= $acc ? $acc->uuid : (string) Uuid::uuid4();

                try {
                    DB::BeginTransaction();
                    //1. STORE USER
                    $dt = UserAggregateRoot::retrieve($id)->register($inp1)->update($inp1)->persist();

                    //2. GRANT AKSES
                    $dt = AccessAggregateRoot::retrieve($id2)->grant($inp2, 'https://basil.id')->accept($inp2['token'])->persist();

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::info('TROUBLE: '.$e);
                }
            }
        }
    }
}
