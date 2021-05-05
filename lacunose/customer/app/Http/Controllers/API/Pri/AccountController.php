<?php

namespace Lacunose\Customer\Http\Controllers\API\Pri;

use Exception, Auth, Flash, Storage, DB, Str;
use Ramsey\Uuid\Uuid;

use App\Http\Controllers\Controller;

use App\Customer;
use Lacunose\Customer\Models\Account;
use Lacunose\Customer\Models\AccountLog;
use Lacunose\Customer\Aggregates\AccountAggregateRoot;

class AccountController extends Controller {
    public function __construct(){
        $this->middleware('tcust.scope:tcust.account.paid')->only('paid');
    }
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index($status) {
        $modes   = Account::distinct('mode')->groupby('mode')->get(['mode']);
        $current        = new account;
        $filtered       = request()->filter ? array_filter(request()->filter) : [];
        if(isset($filtered['mode'])){
            unset($filtered['mode']);
        }

        if($filtered){
            $current= $current->filter($filtered);
        }
        $current    = $current->count();

        $stats['mode']['']  = "Semua ($current)";
        foreach ($modes as $mode) {
            $current        = Account::where('mode', $mode['mode']);
            if($filtered){
                $current    = $current->filter($filtered);
            }
            $current        = $current->count();
            
            $stats['mode'][$mode['mode']]   = $mode['mode']. " ($current)";
        }

        $datas      = new account; 
        if(request()->filter){
            $datas  = $datas->filter(array_filter(request()->filter));
        }

        if(request()->sort){
            $datas  = $datas->sort(array_filter(request()->sort));
        }

        $datas      = $datas->with(['customer'])->paginate(request()->has('per_page') ? request()->get('per_page') : 20);

        $data['stats']  = $stats;
        $data['datas']  = $datas;
        $data['data']['uuid']     = (string) Uuid::uuid4();
        $data['opsi']['period']   = config()->get('tcust.opsi.period');
        $data['opsi']['flag']     = config()->get('tcust.opsi.flag');
        $data['opsi']['scopes']   = Account::getScopes();

        /* GENERATE VIEW */
        return response()->json([
            'status' => true,
            'data'   => $data,
            'message'=> 'AKUN Berhasil Diambil',
        ]);
    }

    public function updated($mode, $id) {
        $input      = request()->get();
        try {
            if(is_null($id)){
                $id =  (string) Uuid::uuid4();
            }

            $doc    = Account::uuid($id);

            DB::beginTransaction();
            $data   = accountAggregateRoot::retrieve($id)->update($input)->persist();
            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'AKUN Berhasil Diupdate',
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

    public function show($mode, $id) {
        $data['data']   = Account::where('mode', $mode)->where('uuid', $id)->firstorfail();
        $data['logs']  = AccountLog::where('account_id', $data['data']['id'])->paginate();

        $data['opsi']['scopes']   = Account::getScopes();

        return response()->json([
            'status' => true,
            'data'   => $data,
            'message'=> 'AKUN Berhasil Diambil',
        ]);
    }

    public function registered($mode, $id) {
        try {
            DB::beginTransaction();
            $data   = accountAggregateRoot::retrieve($id)->customer(request()->get('started_at'))->persist();
            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'AKUN Berhasil Diaktifkan',
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

    public function paid($mode, $id, $no) {
        try {
            DB::beginTransaction();
            $data   = accountAggregateRoot::retrieve($id)->pay($no)->persist();
            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'Tagihan Berhasil Dibayarkan',
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

    public function unregistered($mode, $id) {
        try {
            DB::beginTransaction();
            $data   = accountAggregateRoot::retrieve($id)->uncustomer()->persist();
            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'AKUN Berhasil Dinonaktifkan',
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

    public function deleted($mode, $id) {
        try {
            DB::beginTransaction();
            $data   = accountAggregateRoot::retrieve($id)->delete()->persist();
            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $data,
                'message'=> 'AKUN Berhasil Dihapus',
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
