<?php

namespace App\Http\Controllers\Dashboard;

use View, Auth, Storage, Str;

use App\Models\Catalog;
use App\Models\Document;
use App\Models\Price;
use App\Models\SalesEntry as Sales;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     *
     * @return Response
     */
    public function index() {
        $data['cards']    = [];

        $file   = 'config/business/dashboard.json';
        if (Storage::disk(env('APP_MODE', 'local'))->exists($file)) {
            $setting = collect(json_decode(Storage::disk(env('APP_MODE', 'local'))->get($file), true))->where('user_id', Auth::id())->all();
            if(count($setting)){
                foreach ($setting as $s) {
                    if(Str::is('aging', $s['mode'])){
                        $dsh          = [];
                        $dsh['mode']  = $s['mode'];
                        $dsh['title'] = $s['title'];
                        $dsh['catalogs']  = [];
                        $tipe   = Document::where('type', $s['type'])->groupby('group')->get(['group']);
                        foreach ($tipe as $t) {
                            $jous   = Sales::join('documents', 'documents.id', 'sales_entries.document_id')
                            ->where('documents.group', $t['group'])
                            ->groupby('catalog_id')
                            ->selectraw('catalog_id')
                            ->selectraw('sum(amount) as total')
                            ->havingraw('sum(amount) <> 0')
                            ->with(['catalog'])
                            ->get();

                            $dsh['catalogs'][]  = [
                                'uuid' => strtolower(str_replace('.','',str_replace(' ', '', $t['group']))), 
                                'name' => $t['group'], 
                                'documents' => $jous, 
                                'documents_count' => count($jous)
                            ];
                        }

                        $data['cards'][] = $dsh;

                    }elseif(Str::is('receipt', $s['mode'])){
                        $dsh          = [];
                        $dsh['mode']  = $s['mode'];
                        $dsh['title'] = $s['title'];
                        $dsh['docs']  = Document::whereIn('status', ['settled', 'issued'])->where('type', $s['type'])->get();
                        $data['cards'][] = $dsh;
                    }
                }
            }
        }

        return view('dashboard.index', compact('data'));
    }
}
