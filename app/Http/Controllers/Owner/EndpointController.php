<?php

namespace App\Http\Controllers\Owner;

use DB, Flash, Exception, Str;
use Ramsey\Uuid\Uuid;

use Lacunose\Acl\Models\Endpoint;
use Lacunose\Subscribe\Models\Plan;

use App\Http\Controllers\Controller;

use Lacunose\Acl\Aggregates\EndpointAggregateRoot;

class EndpointController extends Controller {
    /**
     *
     * @return Response
     */
    public function get($website) {
        $data['data']   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $datas          = Endpoint::where('website', $website);

        if(request()->filter){
            $datas      = $datas->filter(array_filter(request()->filter));
        }

        if(request()->sort){
            $datas      = $datas->sort(array_filter(request()->sort));
        }

        $data['endpoints']      = $datas->paginate(request()->has('per_page') ? request()->get('per_page') : 20);
        $data['opsi']['role']   = config()->get('tacl.opsi.role');

        return view('owner.endpoint.get', compact('data'));
    }
    
    /**
     *
     * @return Response
     */
    public function post($website) {
        $plan   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $input  = request()->input();
        $end    = Endpoint::where('website', $website)->where('name', $input['name'])->first();
        if(!$end){
           $website2 = (string) Uuid::uuid4(); 
        }else{
           $website2 = $end->uuid;
        }

        try {
            DB::beginTransaction();
            $dt = EndpointAggregateRoot::retrieve($website2)->save($input)->persist();
            DB::commit();

            Flash::success('Endpoint berhasil ditambahkan.');
            return redirect(route('owner.endpoint.get', $website));
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
    public function delete($website, $name) {
        $plan   = (new Plan)->setConnection(config()->get('web.db.tsub'))->active(now())->where('website', $website)->firstorfail();
        $end    = Endpoint::where('website', $plan['website'])->where('name', $name)->firstorfail();
        try {
            DB::beginTransaction();
            $data   = EndpointAggregateRoot::retrieve($end->uuid)->delete($name, $end->website)->persist();
            DB::commit();

            Flash::success('Endpoint berhasil dinonaktfikan.');
            return redirect(route('owner.endpoint.get', $website));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
}
