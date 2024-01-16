<?php

namespace App\Http\Controllers\Query;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Helpers\BatchHelper;
use Carbon\Carbon;
use DataTables;

class BatchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('queries.batches');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = BatchHelper::data($id);
        if ($data) {
            return view('queries.batches', $data);
        } else {
            return redirect()->route('queries-batches')->with('error', 'Registro não encontrado!');
        }
    }

    public function datatable()
    {
        $data = Batch::with(['user'])
            ->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'queries-batches.show', [$id_field => $row->id_batch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-info btn-sm"><i class="fas fa-search"></i></a>';
                return $actionBtn;
            })
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('created_at', function ($row) {
                return ($row->created_at ? '<span style="display:none">' . $row->created_at . '</span>' . Carbon::parse($row->created_at)->format('d/m/Y H:i:s') : '');
            })
            ->addColumn('refundable_amount', function ($row) {
                return '<span style="display:none">' . $row->refundable_amount . '</span>' . number_format($row->refundable_amount, 2, ',', '.');
            })
            ->addColumn('non_refundable_amount', function ($row) {
                return '<span style="display:none">' . $row->non_refundable_amount . '</span>' . number_format($row->non_refundable_amount, 2, ',', '.');
            })
            ->addColumn('amount', function ($row) {
                return '<span style="display:none">' . $row->amount . '</span>' . number_format($row->amount, 2, ',', '.');
            })
            ->addColumn('active', function ($row) {
                return $row->active ? "<span class='badge badge-success'>Ativo</span>" : "<span class='badge badge-danger'>Fechado</span>";
            })
            ->rawColumns(['actions', 'created_at', 'refundable_amount', 'non_refundable_amount', 'amount', 'active'])
            ->make(true);
    }
}
