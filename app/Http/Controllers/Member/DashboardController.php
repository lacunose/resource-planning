<?php

namespace App\Http\Controllers\Member;

use View, Auth, Storage, Str;

use Lacunose\Acl\Models\Access;
use Lacunose\Subscribe\Models\Plan;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    /**
     *
     * @return Response
     */
    public function index() {
        $data['data']           = Access::get();
        $data['opsi']['scopes'] = Plan::getScopes();

        return view('member.index', compact('data'));
    }
}
