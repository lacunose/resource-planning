<?php

namespace App\Http\Controllers\Dashboard\API;

use Str;

use App\Http\Controllers\Controller;

use Lacunose\Sale\Models\Order as SaleOrder;
use Lacunose\Procure\Models\Order as ProcureOrder;
use Lacunose\Warehouse\Models\Item;
use Lacunose\Warehouse\Models\Document;

class ToolsController extends Controller {
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function search($ref) {
        $data['topic']      = '';
        $data['action']     = '';
        $data['data']       = [];
        $data['batch']      = [];
        
        $action['keluar']['drafted.start']    = 'picking';
        $action['keluar']['drafted.complete'] = 'picking';
        $action['keluar']['drafted.handle']   = 'picking';
        $action['keluar']['stocked.start']    = 'packing.start';
        $action['keluar']['stocked.complete'] = 'packing.complete';
        $action['keluar']['stocked.handle']   = 'overhandling';
        $action['keluar']['submitted']        = 'shipped';

        $action['masuk']['drafted.start']     = 'unpacking.start';
        $action['masuk']['drafted.complete']  = 'unpacking.end';
        $action['masuk']['drafted.handle']    = 'labelled';
        $action['masuk']['stocked.start']     = 'stored';
        $action['masuk']['stocked.complete']  = 'stored';
        $action['masuk']['stocked.handle']    = 'stored';
        $action['masuk']['submitted']         = 'stored';

        $action['opname']['drafted.start']     = 'verifying';
        $action['opname']['drafted.complete']  = 'verifying';
        $action['opname']['drafted.handle']    = 'verifying';
        $action['opname']['stocked.start']     = 'verified';
        $action['opname']['stocked.complete']  = 'verified';
        $action['opname']['stocked.handle']    = 'verified';
        $action['opname']['submitted']         = 'verified';

        $action['konversi']['drafted.start']    = 'converting';
        $action['konversi']['drafted.complete'] = 'converting';
        $action['konversi']['drafted.handle']   = 'converting';
        $action['konversi']['stocked.start']    = 'converted';
        $action['konversi']['stocked.complete'] = 'converted';
        $action['konversi']['stocked.handle']   = 'converted';
        $action['konversi']['submitted']        = 'converted';

        //1. CARI DI WAREHOUSE DOCUMENT
        $dt     = Document::no($ref)->with(['timers', 'timers.user', 'lines'])->first();
        if($dt){
            $data['topic']      = 'twh.document';
            $data['action']     = 'track';

            $tunp   = $dt->timers->where('group', 'unpacking')->count();
            $tpack  = $dt->timers->where('group', 'packing')->count();

            if(Str::is($dt->status, 'drafted') && !$tunp){
                $data['action'] = $action[$dt->cause]['drafted.start'];
            }elseif(Str::is($dt->status, 'drafted') && $tunp && $dt->ux_has_open_timer){
                $data['action'] = $action[$dt->cause]['drafted.complete'];
            }elseif(Str::is($dt->status, 'drafted') && $tunp && !$dt->ux_has_open_timer){
                $data['action'] = $action[$dt->cause]['drafted.handle'];
            }elseif(Str::is($dt->status, 'stocked') && !$tunp){
                $data['action'] = $action[$dt->cause]['stocked.start'];
            }elseif(Str::is($dt->status, 'stocked') && $tunp && $dt->ux_has_open_timer){
                $data['action'] = $action[$dt->cause]['stocked.complete'];
            }elseif(Str::is($dt->status, 'stocked') && $tunp && !$dt->ux_has_open_timer){
                $data['action'] = $action[$dt->cause]['stocked.handle'];
                $batch          = Document::where('cause', $dt->cause)
                    ->where('uuid', '<>', $dt->uuid)
                    ->wheredoesnthave('timers', function($q){$q->wherenull('complete_evidence')->orwherenull('completed_at');})
                    ->Where('status', 'stocked')
                    ->where('sender->courier', $dt->sender['courier'])
                    ->get(['uuid', 'no', 'no_ref', 'receiver', 'owner', 'status', 'sender', 'cause']);
                $data['action'] = $action[$dt->cause]['stocked.handle'];
                $data['batch']  = $batch;
            }elseif(Str::is($dt->status, 'submitted')){
                $batch          = Document::where('cause', $dt->cause)
                    ->where('uuid', '<>', $dt->uuid)
                    ->wheredoesnthave('timers', function($q){$q->wherenull('complete_evidence')->orwherenull('completed_at');})
                    ->WhereIn('status', ['stocked', 'submitted'])
                    ->where('sender->courier', $dt->sender['courier'])
                    ->get(['uuid', 'no', 'no_ref', 'receiver', 'owner', 'status', 'sender', 'cause']);

                $data['action'] = $action[$dt->cause]['submitted'];
                $data['batch']  = $batch;
            }
            $data['data']       = $dt;
        }else{
            //2. CARI DI SALES ORDER
            $dt     = SaleOrder::no($ref)->with(['chats', 'chats.user'])->first();
            if($dt){
                $data['topic']      = 'tsale.transaction';
                $data['action']     = 'track';
                if($dt->ux_has_open_chat){
                    $data['action'] = 'chat';
                }elseif(!$dt->is_printed){
                    $data['action'] = 'print';
                }
                $data['data']       = $dt;
            }else{
                //2. CARI DI SALES ORDER
                $dt     = ProcureOrder::no($ref)->with(['chats', 'chats.user'])->first();
                if($dt){
                    $data['topic']      = 'tproc.transaction';
                    $data['action']     = 'track';
                    if($dt->ux_has_open_chat){
                        $data['action'] = 'chat';
                    }elseif(!$dt->is_printed){
                        $data['action'] = 'print';
                    }elseif(Str::is('opened', $dt->status)){
                        $data['action'] = 'confirm';
                        $data['batch']  = ProcureOrder::where('status', 'opened')->where('warehouse', $dt->warehouse)->where('uuid', '<>', $dt->uuid)->get();
                    }
                    $data['data']       = $dt;
                }else{
                    //3. CARI DI WAREHOUSE ITEM
                    $dt = Item::code($ref)->first();
                    if($dt){
                        $data['topic']      = 'twh.item';
                        $data['action']     = 'track';
                        $data['data']       = $dt;
                    }
                }
            }
        }

        return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'Pencarian telah dilakukan',
            ]);
    }
}
