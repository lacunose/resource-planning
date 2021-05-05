<?php

namespace Lacunose\Customer\Http\Controllers;

use DB, Flash, Exception;
use Ramsey\Uuid\Uuid;

use App\Http\Controllers\Controller;

use Lacunose\Customer\Models\Customer;
use Lacunose\Customer\Models\Program;
use Lacunose\Customer\Aggregates\CustomerAggregateRoot;

class CustomerController extends Controller
{
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index($status) {
         /* GET DATA */
        $active     = Customer::where('status', 'actived')->count();
        $inactive   = Customer::where('status', 'inactived')->count();

        $stats['status']  = [
            'actived'   => config()->get('tcust.glossary.customer.actived')." ($active)",
            'inactived' => config()->get('tcust.glossary.customer.inactived')." ($inactive)",
        ];

        $datas      = Customer::where('status', $status);
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

        return view('tcust::customer.index', compact('data'));
    }

    public function updating($id) {
        $data['data']   = Customer::where('uuid', $id)->first();
        if(!$data['data']){
            $data['data']   = [
                'id'        => 0,
                'uuid'      => $id,
                'pid'       => '',
                'name'      => '',
                'phone'     => '',
                'email'     => '',
                'address'   => '',
                'status'    => 'inactived',
            ];
        }

        return view('tcust::customer.update', compact('data'));
    }

    public function updated($id) {
        $input      = request()->input();
        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->update($input)->persist();
            DB::commit();
            Flash::success('Anggota berhasil disimpan.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id) {
        $data['data']   = Customer::where('uuid', $id)->firstorfail();
        $data['data']['program_ids']= array_column($data['data']['programs']->toArray(), 'id');
        $data['opsi']['mark']       = config()->get('tcust.opsi.mark');
        $data['opsi']['program']    = [];

        $programs       = Program::publish(now())->get();
        foreach ($programs as $program) {
            $data['opsi']['program'][$program->id]  = $program->title;
        }

        return view('tcust::customer.show', compact('data'));
    }
    
    public function activated($id) {

        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->activate()->persist();
            DB::commit();
            Flash::success('Pelanggan berhasil diaktifkan.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function inactivated($id) {
        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->inactivate()->persist();
            DB::commit();
            Flash::success('Pelanggan berhasil dinonaktifkan.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function programmed($id) {
        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->program(request()->get('program'))->persist();
            DB::commit();
            Flash::success('Pelanggan berhasil bergabung.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
    
    public function unprogrammed($id) {
        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->unprogram(request()->get('unprogram'))->persist();
            DB::commit();
            Flash::success('Pelanggan berhasil bergabung.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function marked($id) {
        $data   = request()->get('marks');
        $marks  = json_decode($data['catalog'], true);

        try {
            foreach ($marks as $code => $name) {
                $input  = [
                    'type'          => $data['type'],
                    'catalog_name'  => $name,
                    'catalog_code'  => $code,
                ];

                DB::BeginTransaction();
                $dt = CustomerAggregateRoot::retrieve($id)->mark($input)->persist();
                DB::commit();
            }
            Flash::success('Pelanggan berhasil bergabung.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function unmarked($id) {
        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->unmark(request()->get('unmark'))->persist();
            DB::commit();
            Flash::success('Pelanggan berhasil bergabung.');
            return redirect(route('tcust.customer.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function deleted($id) {

        try {
            DB::BeginTransaction();
            $data   = CustomerAggregateRoot::retrieve($id)->delete()->persist();
            DB::commit();
            Flash::success('Pelanggan berhasil dihapus.');
            return redirect(route('tcust.customer.index', ['status' => 'actived', 'sort[code]' => 'asc']));
        } catch (Exception $e) {
            DB::rollback();
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
}
