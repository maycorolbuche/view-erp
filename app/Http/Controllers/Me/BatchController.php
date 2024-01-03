<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Expense;
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
        $data = Batch::where('id_user', Auth::id())->with([
            'categories' => function ($query) {
                $query->orderBy('short_name');
            },
            'clients' => function ($query) {
                $query->orderBy('short_name');
            },
            'expenses' => function ($query) {
                $query->orderBy('date');
            },
            'discounts'
        ])->find($id);
        if ($data) {
            $chart_categories = $data->categories->map(function ($category) {
                return [
                    'name' => $category['short_name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            $chart_clients = $data->clients->map(function ($category) {
                return [
                    'name' => $category['short_name'],
                    'y' => floatval($category['pivot']['amount']),
                ];
            })->toArray();

            return view('me.batches.index', compact('data', 'chart_categories', 'chart_clients'));
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
    public function destroy($id)
    {
        try {
            $batch = Batch::find($id);
            if ($batch) {
                if (!$batch->active) {
                    return redirect()->back()->with('error', 'Este lote não pode ser desfeito, pois já foi processado!')->withInput();
                }
                Expense::where('id_batch', $id)->update(['id_batch' => null]);
                $batch->delete();
                return redirect()->route('me-batches')->with('success', 'Registro apagado com sucesso');
            } else {
                return redirect()->route('me-batches')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
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
