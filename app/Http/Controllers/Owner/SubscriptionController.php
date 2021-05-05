<?php

namespace App\Http\Controllers\Owner;

use View, Auth, Storage, Str, Flash, DB;

use Lacunose\Subscribe\Models\Plan;
use Lacunose\Subscribe\Models\PlanBill;

use App\Http\Controllers\Controller;

use Lacunose\Subscribe\Aggregates\SubscriptionAggregateRoot;

class SubscriptionController extends Controller {
    /**
     *
     * @return Response
     */
    public function get($website) {
        $data['data']   = (new Plan)->setConnection(config()->get('tswirl.db.tsub'))->where('website', $website)->firstorfail();
        $datas          = (new PlanBill)->setConnection(config()->get('tswirl.db.tsub'))->where('plan_id', $data['data']->id);

        if(request()->filter){
            $datas      = $datas->filter(array_filter(request()->filter));
        }

        if(request()->sort){
            $datas      = $datas->sort(array_filter(request()->sort));
        }

        $data['bills']  = $datas->paginate(request()->has('per_page') ? request()->get('per_page') : 20);

        return view('owner.subscription.get', compact('data'));
    }

    /**
     *
     * @return Response
     */
    public function bayar() {
        $bill   = (new PlanBill)->setConnection(config()->get('tswirl.db.tsub'))->where('no', request()->get('order_id'))->firstorfail();
        $nb     = $bill->no.'-'.time();
        $params = [
            'transaction_details'   => [
                'order_id'          => $nb,
                'gross_amount'      => $bill->ux_bill,
            ],
        ];

        \Midtrans\Config::$serverKey   = 'SB-Mid-server-n8uVCymQAb0jSL1mOO5p0cEt';
        \Midtrans\Config::$clientKey   = 'SB-Mid-client-YpPanZlIJD73XzGp';

        try {
          // Get Snap Payment Page URL
          $purl = \Midtrans\Snap::createTransaction($params)->redirect_url;
          
          // Redirect to Snap Payment Page
          header('Location: ' . $purl);
        }
        catch (Exception $e) {
          echo $e->getMessage();
        }
        exit;
    }


    /**
     *
     * @return Response
     */
    public function lunas() {
        \Midtrans\Config::$serverKey   = 'SB-Mid-server-n8uVCymQAb0jSL1mOO5p0cEt';
        \Midtrans\Config::$clientKey   = 'SB-Mid-client-YpPanZlIJD73XzGp';

        $status = \Midtrans\Transaction::status(request()->get('order_id'));
        try {
            DB::beginTransaction();
            if(Str::is($status->transaction_status, 'settlement')) {
                $no     = explode('-', request()->get('order_id'))[0];
                $bill   = (new PlanBill)->setConnection(config()->get('tswirl.db.tsub'))->where('no', $no)->firstorfail();
                $url    = $bill->plan->website;
                $data   = SubscriptionAggregateRoot::retrieve($bill->plan->uuid)->pay($no, $url)->persist();
                Flash::success('Tagihan berhasil dibayar.');
            }elseif(Str::is($status->transaction_status, 'pending')) {
                $no     = explode('-', request()->get('order_id'))[0];
                $bill   = (new PlanBill)->setConnection(config()->get('tswirl.db.tsub'))->where('no', $no)->firstorfail();
                $url    = $bill->plan->website;
                $data   = SubscriptionAggregateRoot::retrieve($bill->plan->uuid)->pay($no, $url)->persist();
                Flash::success('Pembayaran sedang diproses.');
            }
            DB::commit();
            return redirect(route('owner.subscription.get', $bill->plan->website));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
}
