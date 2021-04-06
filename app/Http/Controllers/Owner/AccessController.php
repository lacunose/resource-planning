<?php

namespace App\Http\Controllers\Owner;

use DB, Flash, Exception, Str;
use Ramsey\Uuid\Uuid;

use Lacunose\Acl\Models\Access;
use Lacunose\Acl\Models\Endpoint;
use Lacunose\Subscribe\Models\Plan;

use App\Http\Controllers\Controller;

use Lacunose\Acl\Aggregates\AccessAggregateRoot;

class AccessController extends Controller {
    /**
     *
     * @return Response
     */
    public function get($website) {
        $data['data']   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $datas          = Access::where('website', $website);

        if(request()->filter){
            $datas      = $datas->filter(array_filter(request()->filter));
        }

        if(request()->sort){
            $datas      = $datas->sort(array_filter(request()->sort));
        }
        $role   = Access::where('website', $website)->distinct('role')->groupby('role')->get(['role']);
        $point  = Endpoint::where('website', $website)->get();
        $data['opsi']['endpoints']  = [];
        foreach ($point as $p) {
            $data['opsi']['endpoints'][$p['id']]    = $p['ux_name'];
        }

        $data['opsi']['role']       = [];
        foreach ($role as $r) {
            $data['opsi']['role'][$r['role']]       = $r['role'];
        }

        $data['accesses']           = $datas->paginate(request()->has('per_page') ? request()->get('per_page') : 20);
        $data['opsi']['scopes']     = Plan::getScopes();
        $data['opsi']['scope']      = array_column(Plan::getScopes(), 'scopes');
        $data['opsi']['clients']    = $data['data']->ux_clients;

        return view('owner.access.get', compact('data'));
    }
    
    public function show($website, $email) {
        
        $data['data']   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $data['access']    = Access::where('website', $website)->where('email', $email)->firstorfail();

        $role   = Access::where('website', $website)->distinct('role')->groupby('role')->get(['role']);
        $point  = Endpoint::where('website', $website)->get();
        $data['opsi']['endpoints']  = [];
        foreach ($point as $p) {
            $data['opsi']['endpoints'][$p['id']]    = $p['ux_name'];
        }

        $data['opsi']['role']       = [];
        foreach ($role as $r) {
            $data['opsi']['role'][$r['role']]       = $r['role'];
        }

        $data['opsi']['scopes']     = Plan::getScopes();
        $data['opsi']['scope']      = array_column(Plan::getScopes(), 'scopes');
        $data['opsi']['clients']    = Plan::getClients();

        return view('owner.access.show', compact('data'));
    }
    /**
     *
     * @return Response
     */
    public function post($website) {
        $plan   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $input  = request()->input();
        $input['token'] = Str::random(32);
        $url    = route('inviting', [$website, $input['token']]);
        $acc    = Access::where('website', $website)->where('email', $input['email'])->first();

        if(!$acc){
           $id2 = (string) Uuid::uuid4(); 
        }else{
           $id2 = $acc->uuid;
        }

        try {
            DB::beginTransaction();
            $dt = AccessAggregateRoot::retrieve($id2)->grant($input, $url)->persist();
            DB::commit();

            Flash::success('Akses berhasil ditambahkan.');
            return redirect(route('owner.access.get', $website));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     *
     * @return Response
     */


    public function delete($website, $email) {
        $plan   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $acc    = Access::where('website', $plan['website'])->where('email', $email)->firstorfail();
        try {
            DB::beginTransaction();
            $data   = AccessAggregateRoot::retrieve($acc->uuid)->revoke($email, $plan->website)->persist();
            DB::commit();

            Flash::success('Akses berhasil dinonaktfikan.');
            return redirect(route('owner.access.get', $website));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
}
