<?php

namespace App\Http\Controllers\Dashboard\API;

use DB, Exception, Log, Storage, Str;

use App\Http\Controllers\Controller;

use Lacunose\Warehouse\Models\Document;
use Lacunose\Warehouse\Models\StockEntry as Stock;

use Lacunose\Warehouse\Aggregates\DocumentAggregateRoot;

class DocumentController extends Controller {
    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function submitted($cause) {
        $courier    = request()->get('courier');
        $refs       = request()->get('refs');
        $nos        = request()->get('nos');

        try {
            DB::beginTransaction();
            foreach ($nos as $no) {
                $doc    = Document::no($no)->where('cause', $cause)->whereIn('status', ['stocked', 'submitted'])->where('sender->courier', $courier)->firstorfail();
                $data   = DocumentAggregateRoot::retrieve($doc->uuid)->submit($refs)->persist();
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

    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function locked($cause) {
        $courier    = request()->get('courier');
        $refs       = request()->get('refs');
        $nos        = request()->get('nos');

        try {
            DB::beginTransaction();

            foreach ($nos as $no) {
                $doc    = Document::no($no)->where('cause', $cause)->whereIn('status', ['locked', 'submitted'])->where('sender->courier', $courier)->firstorfail();
                $data   = DocumentAggregateRoot::retrieve($doc->uuid)->lock($refs)->persist();
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

    public function show($cause, $no) {
        $data['data']       = Document::where('cause', $cause)
            ->no($no)
            ->with(['drafter', 'submitter', 'stockist', 'locker', 'archivist'])
            ->firstorfail();

        $data['stocks']         = Stock::where('document_id', $data['data']['id'])->get();
        $codes  = array_column($data['data']->lines, 'dock_code');
        $data['opsi']['items']  = Item::whereIn('code', $codes)->where('status', 'submitted')->get();

        DocumentAggregateRoot::retrieve($data['data']['uuid'])->see()->persist();

        /* GENERATE RESPONSE */
        return response()->json([
            'status' => true,
            'data'   => $data,
            'message'=> 'Data Berhasil diambil',
        ]);
    }

    /**
     *
     * @param Request $request
     *
     * @return Response
     */
    public function unpacked($cause, $id) {
        $group  = request()->get('group');
        $refs   = request()->get('refs');
        $doc    = Document::where('cause', $cause)->where('uuid', $id)->whereIn('status', ['drafted'])->firstorfail();
        $input  = $doc->toArray();
        $input['lines'] = request()->get('lines'); 

        try {
            DB::beginTransaction();
            $dt = DocumentAggregateRoot::retrieve($id)->draft($input, [])->timer($group, $refs)->persist();
            DB::commit();
          
            return response()->json([
                'status' => true,
                'data'   => $input['lines'],
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
