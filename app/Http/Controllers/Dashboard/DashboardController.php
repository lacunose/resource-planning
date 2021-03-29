<?php

namespace App\Http\Controllers\Dashboard;

use View, Auth, Storage, Str;

use App\Models\Catalog;
use App\Models\Document;
use App\Models\Price;
use App\Models\SalesEntry as Sales;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    /**
     *
     * @return Response
     */
    public function index() {
        $data['cards']    = [];

        return view('dashboard.index', compact('data'));
    }
}
