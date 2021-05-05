<?php

namespace Lacunose\Customer\Http\Controllers;

use View, Exception, Auth, Flash, Storage, DB, Str, PDF;
use Ramsey\Uuid\Uuid;

use App\Http\Controllers\Controller;

use Lacunose\Customer\Models\Customer;
use Lacunose\Customer\Models\Account;
use Lacunose\Customer\Models\AccountLog;
use Lacunose\Customer\Aggregates\AccountAggregateRoot;

class AccountController extends Controller {
    public function __construct(){
        $this->middleware('tacl.scope:tcust.account.verified')->only('verified');
    }
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index($status) {
        /* GET DATA */
        $active     = Account::status('opened')->count();
        $inactive   = Account::status('closed')->count();

        $stats['status']  = [
            'opened'   => config()->get('tcust.glossary.account.opened')." ($active)",
            'closed' => config()->get('tcust.glossary.account.closed')." ($inactive)",
        ];

        $current    = Account::status($status);

        if(request()->filter){
            $current= $current->filter(array_filter(request()->filter));
        }
        $current    = $current->count();

        $datas      = Account::status($status); 
        if(request()->filter){
            $datas  = $datas->filter(array_filter(request()->filter));
        }

        if(request()->sort){
            $datas  = $datas->sort(array_filter(request()->sort));
        }

        $datas      = $datas->paginate(request()->has('per_page') ? request()->get('per_page') : 20);

        $data['stats']  = $stats;
        $data['datas']  = $datas;
        $data['data']['uuid']   = (string) Uuid::uuid4();

        /* GENERATE VIEW */
        return view('tcust::account.index', compact('data'));
    }

    public function opening($id) {
        $data['data']   = Account::where('uuid', $id)->first();
        if(!$data['data']){
            $data['data']   = [
                'id'            => 0,
                'uuid'          => $id,
                'no'            => '',
                'customer_id'   => null,
                'status'        => 'opened',
                'resetted_at'   => now()->format('Y-m-d'),
                'reset_period'  => 'yearly',
                'currency'      => 'idr',
                'exchange_rate_to_idr'  => 1,
            ];
        }

        $data['opsi']['period']   = config()->get('tcust.opsi.period');
        $data['opsi']['currency'] = config()->get('tcust.opsi.currency');
        $data['opsi']['customer'] = [];
        $data['default']['no_ref']  = '';

        $customers       = Customer::status('actived')->get();
        foreach ($customers as $customer) {
            $data['opsi']['customer'][$customer->id]  = $customer->name;
        }

        $data['logs']   = [];

        return view('tcust::account.open', compact('data'));
    }
    
    public function opened($id) {
        $input  = request()->all();

        try {
            if(is_null($id)){
                $id =  (string) Uuid::uuid4();
            }

            $doc    = Account::uuid($id);

            DB::beginTransaction();
            $data   = AccountAggregateRoot::retrieve($id)->open($input)->persist();
            DB::commit();

            Flash::success('Akun berhasil disimpan.');
            return redirect(route('tcust.account.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();

            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id) {
        $data['data']   = Account::where('uuid', $id)->firstorfail();
        $data['logs']   = AccountLog::where('account_id', $data['data']['id'])->paginate();
        $data['default']['no_ref']  = AccountLog::generateNo();

        return view('tcust::account.show', compact('data'));
    }

    public function issued($id) {
        $input  = request()->all();
        try {
            DB::beginTransaction();
            $data   = AccountAggregateRoot::retrieve($id)->issue($input)->persist();
            DB::commit();

            Flash::success('Transaksi berhasil ditambahkan.');
            return redirect(route('tcust.account.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function verified($id) {
        $nos    = [request()->get('no')];
        try {
            DB::beginTransaction();
            $data   = AccountAggregateRoot::retrieve($id)->verify($nos)->persist();
            DB::commit();

            Flash::success('Transaksi berhasil diverifikasi.');
            return redirect(route('tcust.account.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function closed($id) {
        try {
            DB::beginTransaction();
            $data   = AccountAggregateRoot::retrieve($id)->close()->persist();
            DB::commit();

            Flash::success('Akun berhasil dinonaktifkan.');
            return redirect(route('tcust.account.index', ['status' => 'opened']));
        } catch (Exception $e) {
            DB::rollback();

            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
}
