<?php

namespace App\Http\Controllers\Dashboard\API;

use DB, Exception, Log, Storage, Str;

use App\Http\Controllers\Controller;

use Lacunose\Sale\Models\Order;

use Lacunose\Sale\Aggregates\TransactionAggregateRoot;

class TransactionController extends Controller {
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function discussion($no) {
        try {
            $order  = Order::no($no)->with(['chats', 'chats.user'])->firstorfail();

            return response()->json([
                'status' => true,
                'data'   => $order->chats,
                'message'=> 'Data Berhasil Diambil',
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'data'   => [],
                'message'=> $e->getMessage(),
            ]);
        }
    }

    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function discuss($no) {
        try {
            $order  = Order::no($no)->firstorfail();

            DB::BeginTransaction();
          
            $data   = TransactionAggregateRoot::retrieve($order->uuid)->discuss(request()->get('message'))->persist();
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'Data Berhasil Disimpan',
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'data'   => [],
                'message'=> $e->getMessage(),
            ]);
        }
    }

    public function show($no) {
        $data['data']           = Order::no($no)
            ->with(['payments', 'payments.user'])
            ->firstorfail();

        return response()->json([
            'status' => true,
            'data'   => $data,
            'message'=> 'Transaksi Berhasil Diambil',
        ]);
    }

    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function process($process) {
        $warehouse  = request()->get('warehouse');
        $nos        = request()->get('nos');

        try {
            DB::beginTransaction();
            foreach ($nos as $no) {
                $order  = Order::no($no)->where('warehouse', $warehouse)
                    ->whereIn('status', ['opened', 'processed'])
                    ->where(function($q)use($process){
                        $q
                        ->where('processes', 'like', '%'.json_encode(['state' => $process, 'is_executed' => true]).'%')
                        ->orwhere('processes', 'not like', '%'.json_encode(['state' => $process, 'is_executed' => true]).'%')
                        ->orwherenull('processes')
                        ;
                    })
                    ->firstorfail();
                if(request()->has('reason')) {
                    $data= TransactionAggregateRoot::retrieve($order->uuid)->process($process)->discuss(request()->get('reason'))->persist();
                }else{
                    $data= TransactionAggregateRoot::retrieve($order->uuid)->process($process)->persist();
                }
            }
            DB::commit();
          
            return response()->json([
                'status' => true,
                'data'   => $nos,
                'message'=> 'Data Berhasil Disimpan',
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'data'   => [],
                'message'=> $e->getMessage(),
            ]);
        }
    }

}
