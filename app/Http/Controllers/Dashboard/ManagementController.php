<?php

namespace App\Http\Controllers\Dashboard;

use Storage, Flash;

use App\AppConflict;
use Lacunose\Warehouse\Models\Item;

use App\Http\Controllers\Controller;

class ManagementController extends Controller {
    /**
     *
     * get
     *
     */
    public function onhold_get() {
        $data['datas']  = [];
        $file           = 'config/strategy/stock/onhold.json';

        $data['opsi']['items']  = Item::select(['id', 'name', 'code', 'status'])->get()->toArray();

        if (Storage::disk(env('APP_MODE', 'local'))->exists($file)) {
            $data['datas']  = json_decode(Storage::disk(env('APP_MODE', 'local'))->get($file), true);
        }

        return view('dashboard.stock.onhold', compact('data'));
    }

    /**
     * post
     *
     */
    public function onhold_post() {
        /*----------  Process  ----------*/
        try {
            $onholds= [];
            $inp    = request()->get('onholds');

            foreach ($inp['item_code'] as $k => $t) {
                $onholds[]    = [
                    'item_code' => $t, 
                    'hold'      => $inp['hold'][$k],
                ];
            }

            $file   = 'config/strategy/stock/onhold.json';
            if (Storage::disk(env('APP_MODE', 'local'))->exists($file)) {
                Storage::disk(env('APP_MODE', 'local'))->delete($file);
            }
            Storage::disk(env('APP_MODE', 'local'))->put($file, json_encode($onholds));
            return redirect()->route('stock.onhold.get');
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('stock.onhold.get'));
        }
    }

    /**
     *
     * get
     *
     */
    public function conflict_get($topic) {
        $filtered   = request()->has('filter') ? array_filter(request()->filter, static function($var){return $var !== null;}) : [];
        $sorted     = request()->has('sort') ? array_filter(request()->sort, static function($var){return $var !== null;}) : [];

        $data['datas']  = AppConflict::where('topic', $topic)->filter($filtered)->sort($sorted)->paginate();

        return view('dashboard.conflict.index', compact('data'));
    }
}
