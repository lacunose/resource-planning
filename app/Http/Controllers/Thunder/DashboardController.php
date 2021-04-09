<?php

namespace App\Http\Controllers\Thunder;

use View, Auth, Storage, Str;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    /**
     *
     * @return Response
     */
    public function index() {
        $data['cards']    = [];
        return view('thunder.index', compact('data'));
    }
}
