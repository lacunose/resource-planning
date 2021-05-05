<?php

namespace Lacunose\Customer\Http\Controllers;

use View, Flash, DB;

use Ramsey\Uuid\Uuid;

use App\Http\Controllers\Controller;

use Lacunose\Customer\Models\Account;
use Lacunose\Customer\Models\Program;

use Lacunose\Customer\Aggregates\ProgramAggregateRoot;

class ProgramController extends Controller {
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index($status) {
         /* GET DATA */
        $publish    = Program::publish(now())->count();
        $unpublish  = Program::unpublish(now())->count();

        $stats['status']  = [
            'published'     => config()->get('tcust.glossary.program.published')." ($publish)",
            'unpublished'   => config()->get('tcust.glossary.program.unpublished')." ($unpublish)",
        ];

        $datas      = Program::status($status);
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

        return view('tcust::program.index', compact('data'));
    }

    public function saving($id) {
        $data['data']   = Program::where('uuid', $id)->first();
        if(!$data['data']){
            $data['data']   = [
                'id'         => 0,
                'uuid'       => $id,
                'title'      => null,
                'trigger_event' => null,
                'trigger_param' => null,
                'trigger_value' => null,
                'trigger_loop'  => 0,
                'target_event'  => null,
                'target_gain'   => 0,
                'target_field'  => null,
                'target_value'  => null,
                'status'        => 'unpublished',
                'ux_trigger_param' => null,
                'ux_target_field'  => null,
            ];
        }

        $data['opsi']['period'] = config()->get('tcust.opsi.period');
        $data['opsi']['trigger']= config()->get('tcust.opsi.trigger');
        $data['opsi']['target'] = config()->get('tcust.opsi.target');
        $data['opsi']['param']  = config()->get('tcust.opsi.param');
        $data['opsi']['field']  = config()->get('tcust.opsi.field');

        return view('tcust::program.save', compact('data'));
    }

    public function saved($id) {
        $input      = request()->all();
       
        try {
            if(is_null($id)){
                $id =  (string) Uuid::uuid4();
            }

            DB::beginTransaction();
            $data   = ProgramAggregateRoot::retrieve($id)->save($input)->persist();
            DB::commit();

            Flash::success('Program berhasil disimpan.');
            return redirect(route('tcust.program.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();

            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id) {
        $data['data']   = Program::where('uuid', $id)->firstorfail();

        return view('tcust::program.show', compact('data'));
    }
    
    public function published($id) {

        try {
            DB::beginTransaction();
            $data   = ProgramAggregateRoot::retrieve($id)
                ->publish(request()->get('published_at'), request()->get('published_until'))
                ->persist();
            DB::commit();

            Flash::success('Program berhasil dipublish.');
            return redirect(route('tcust.program.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();

            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function unpublished($id) {

        try {
            DB::beginTransaction();
            $data   = ProgramAggregateRoot::retrieve($id)
                ->unpublish(request()->get('published_until'))
                ->persist();
            DB::commit();

            Flash::success('Program berhasil diunpublish.');
            return redirect(route('tcust.program.show', ['id' => $id]));
        } catch (Exception $e) {
            DB::rollback();

            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
    
    public function deleted($id) {

        try {
            DB::beginTransaction();
            $data   = ProgramAggregateRoot::retrieve($id)->delete()->persist();
            DB::commit();

            Flash::success('Program berhasil dihapus.');
            return redirect(route('tcust.program.index', ['status' => 'saved', 'sort[code]' => 'asc']));
        } catch (Exception $e) {
            DB::rollback();

            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }
}
