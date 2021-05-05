<?php

namespace Lacunose\Customer\Http\Controllers;

use View;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Lacunose\Customer\Models\Account;
use Lacunose\Customer\Models\AccountLog;

class ReportController extends Controller
{
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function log($mode) {
        $datas      = AccountLog::mode($mode); 
        $ytd        = AccountLog::mode($mode);
        if(request()->filter){
            $datas  = $datas->filter(array_filter(request()->filter));
            $ytdf   = request()->filter;
            if(isset($ytdf['date_gte'])){
                $ytdf['date_lt']    = $ytdf['date_gte'];
                unset($ytdf['date_gte']);
            }else{
                $ytdf['date_lt']    = now()->subdays(1)->format('Y-m-d');
            }
            if(isset($ytdf['date_lte'])){
                unset($ytdf['date_lte']);
            }
            $ytd    = $ytd->filter(array_filter($ytdf));
        }

        if(request()->sort){
            $datas  = $datas->sort(array_filter(request()->sort));
            $ytd    = $ytd->sort(array_filter(request()->sort));
        }

        $data['stats']['balance']= clone $datas;
        $data['logs']           = $datas->paginate(request()->has('per_page') ? request()->get('per_page') : 20);
        
        $data['infos']['title']  = config()->get('tcust.title.log.'.$mode);

        $data['stats']['start']  = $ytd->sum('amount');
        $data['stats']['balance']= $ytd->sum('amount') + $data['stats']['balance']->sum('amount');

        return view('tcust::log.index', compact('data'));
    }
}
