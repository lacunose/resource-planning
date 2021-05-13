<?php

namespace App\Http\Controllers\Web;

use Flash, DB, Exception, Auth;
use Ramsey\Uuid\Uuid;

use App\User;
use Lacunose\Acl\Models\Access;
use Lacunose\Subscribe\Models\Plan;
use Lacunose\Subscribe\Models\Price;

use App\Http\Controllers\Controller;
use Lacunose\Acl\Aggregates\AccessAggregateRoot;
use Lacunose\Acl\Aggregates\UserAggregateRoot;
use Lacunose\Subscribe\Aggregates\SubscriptionAggregateRoot;

class WebsiteController extends Controller {
    /**
     *
     * @return Response
     */
    public function dashboard() {
        return view('web.subscribed');
    }
    
    
    public function signin() {
        return view('web.login');
    }

    public function registering() {
        return view('web.register');
    }

    public function registered() {
        $id     = (string) Uuid::uuid4();
        $user   = request()->only('name', 'email', 'password');
        try {
            DB::beginTransaction();
            //1. REGISTER USER
            $dt     = UserAggregateRoot::retrieve($id)->register($user)->request_verification_token()->persist();
            DB::commit();

            // dd('Berhasil daftar. Tolong cek email.');
            return redirect(route('login'));
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back();
        }
    }

    /**
     *
     * @return Response
     */
    public function verified($id, $token) {
        try {
            DB::beginTransaction();
            $dt     = UserAggregateRoot::retrieve($id)->verify($token)->persist();
            DB::commit();
            // dd('Akun berhasil diverifikasi. Silahkan subscribe.');
            return redirect($url);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect(route('subscribing'));
        }
    }

    /**
     *
     * @return Response
     */
    public function subscribing() {
        $data['packages']   = Price::status('published')->get();

        return view('web.subscribe', compact('data'));
    }

    public function subscribed() {
        $id     = (string) Uuid::uuid4();
        $pack   = Price::findorfail(request()->get('price_id'));
        $st     = now();
        $url    = route('owner.subscription.get', request()->get('website'));

        $input  = request()->only('website');
        $input['biller']    = request()->only('name', 'phone', 'email', 'address', 'business');
        $input['issuer']    = [
                                'name'      => config()->get('tsub.name'),
                                'phone'     => config()->get('tsub.whatsapp'),
                                'email'     => config()->get('tsub.email'),
                                'address'   => config()->get('tsub.address'),
                                'business'  => config()->get('tsub.business'),
                            ];
        $input['ended_at']  = $st;
        $input['period']    = $pack->period;
        $input['membership']= $pack->membership;
        $input['contract']  = $pack->contract;
        $input['clients']   = $pack->clients;
        $input['scopes']    = $pack->scopes;
        $input['email']     = auth::check() ? auth::user()->email : null;

        try {
            DB::beginTransaction();
            //1. SUBSCRIBE PLAN
            $dt     = SubscriptionAggregateRoot::retrieve($id)->update($input)->subscribe($st, $url)->persist();
            DB::commit();

            return redirect($url);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }


    /**
     *
     * @return Response
     */
    public function inviting($website, $token) {
        $data['data']   = Access::where('website', $website)->where('token', $token)->wherenull('accepted_at')->firstorfail();

        return view('web.invite', compact('data'));
    }

    public function invited($website, $token) {
        $access = Access::where('website', $website)->where('token', $token)->wherenull('accepted_at')->firstorfail();
        $user   = request()->only('name', 'password');
        $user['scopes'] = [];
        $user['email']  = $access->email;

        try {
            DB::beginTransaction();
            if(!$access->user){
                $uuid   =  (string) Uuid::uuid4();
                $data   = UserAggregateRoot::retrieve($uuid)->register($user)->verify_without_token()->persist();
            }
            $dt = AccessAggregateRoot::retrieve($access->uuid)->accept($token)->persist();
            $ac = Access::where('website', $website)->where('email', $access->email)->firstorfail();
            DB::commit();
            dd('Undangan diterima. Login ke member lalu akses tenant');
            return redirect($ac->user->level);

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }
}