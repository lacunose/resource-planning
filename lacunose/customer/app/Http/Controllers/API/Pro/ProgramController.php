<?php

namespace Lacunose\Customer\Http\Controllers\API\Pro;

use DB, Str, Hash, Arr;
use Ramsey\Uuid\Uuid;

use App\Http\Controllers\Controller;

use Lacunose\Customer\Models\Program;

class ProgramController extends Controller
{
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index($status) {
         /* GET DATA */
        $publish   = Program::publish(now())->count();

        $stats['status']  = [
            'published'     => config()->get('tcust.glossary.program.published')." ($publish)",
            'unpublished'   => config()->get('tcust.glossary.program.unpublished'),
        ];

        $datas      = Program::status($status);
        if(request()->filter){
            $datas  = $datas->filter(array_filter(request()->filter));
        }

        if(request()->sort){
            $datas  = $datas->sort(array_filter(request()->sort));
        }

        if(request()->has('sent_all') && request()->get('sent_all')){
            $datas  = $datas->get();
        }else{
            $datas  = $datas->paginate(request()->has('per_page') ? request()->get('per_page') : 20);
        }

        $data['datas']  = $datas;
        $data['data']['uuid']       = (string) Uuid::uuid4();

       return response()->json([
            'status' => true,
            'data'   => $data,
            'message'=> 'Data Berhasil Diambil',
        ]);
    }
}
