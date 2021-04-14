<?php

namespace App\Http\Controllers\Dashboard;

use Storage, Flash;

use App\AppConflict;
use Lacunose\Warehouse\Models\Item;

use App\Http\Controllers\Controller;

class ManagementController extends Controller {
 
    public function conflict_get($topic) {
        $filtered   = request()->has('filter') ? array_filter(request()->filter, static function($var){return $var !== null;}) : [];
        $sorted     = request()->has('sort') ? array_filter(request()->sort, static function($var){return $var !== null;}) : [];

        $data['datas']  = AppConflict::where('topic', $topic)->filter($filtered)->sort($sorted)->paginate();

        return view('dashboard.conflict.index', compact('data'));
    }
}
