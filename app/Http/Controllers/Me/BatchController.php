<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('me.batches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Batch::where('id_user', Auth::id())->find($id);
        if ($data) {
            return view('me.batches.index', compact('data'));
        } else {
            return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* $edit = BatchHelper::pendingBatch($id);
        if (!$edit) {
            return redirect()->back()->with('error', 'Você não tem permissão autorizar/negar este item!')->withInput();
        }

        try {
            $batch = Batch::find($id);
            if ($batch) {
                $status = $request->status;
                if ($status == "") {
                    return redirect()->back()->with('error', 'Uma resposta deve ser escolhida!')->withInput();
                }

                $description = $request->description;
                if ($status == "N" && trim($description) == "") {
                    return redirect()->back()->with('error', 'O motivo da recusa deve ser informado!')->withInput();
                }

                $batch_status = BatchStatus::where(['id_batch' => $id, 'id_user' => Auth::id()]);
                if ($batch_status) {
                    $batch_status->update(['id_batch' => $id, 'id_user' => Auth::id(), 'approved' => $status == 'S', 'description' => $description]);
                    BatchHelper::refresh($id);

                    try {
                        $this->sendMail($id);
                        return redirect()->route('me-batches.show', ['id' => $batch->id_batch])->with('success', 'Status atualizado com sucesso');
                    } catch (\Exception $e) {
                        return redirect()->back()->with('error', 'O status foi salvo com sucesso, porém, houve um erro ao enviar e-mail aos envolvidos.')->withInput();
                    }
                }
            } else {
                return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }*/
    }

    public function datatable()
    {
        $data = Batch::with(['user'])
            ->where('id_user', Auth::id())
            ->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-batches.show', [$id_field => $row->id_batch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
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
