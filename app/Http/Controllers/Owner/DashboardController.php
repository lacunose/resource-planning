<?php

namespace App\Http\Controllers\Owner;

use View, Auth, Storage, Str;

use Lacunose\Subscribe\Models\Plan;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    /**
     *
     * @return Response
     */
    public function index() {
        $data['cards']		= [];
        return view('owner.index', compact('data'));
    }
}
