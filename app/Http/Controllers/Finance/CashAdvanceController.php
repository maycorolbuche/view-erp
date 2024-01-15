<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCashHistory;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

class CashAdvanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash-advances.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id_user', $id)->with('user_cash')->first();
        if ($data) {
            $user_cash = UserHelper::getCash($data->id_user);
            return view('cash-advances.index', compact('data', 'user_cash'));
        } else {
            return redirect()->route('cash-advances')->with('error', 'Registro não encontrado!');
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
        if (!in_array('update', request('__permissions_page'))) {
            return redirect()->back()->with('error', 'Você não tem permissão para salvar nessa página!')->withInput();
        }

        try {
            $user = User::where('id_user', $id)->first();
            if ($user) {
                $amount = $request->input('amount');
                $description = $request->input('description');
                $transaction = $request->input('transaction');
                if ($amount == 0) {
                    return redirect()->back()->with('error', 'O valor não pode ser igual a zero!')->withInput();
                } elseif (trim($description) == "") {
                    return redirect()->back()->with('error', 'Informe o motivo!')->withInput();
                } else {

                    if ($transaction == "add") {
                        UserHelper::addCash($id, $amount, [
                            'description' => $description,
                        ]);
                    } else {
                        UserHelper::removeCash($id, $amount, [
                            'description' => $description,
                        ]);
                    }
                    return redirect()->route('cash-advances.show', ['id' => $id])->with('success', 'Transação registrada com sucesso');
                }
            } else {
                return redirect()->route('cash-advances')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


    public function datatable()
    {
        $type = request('type') ?? "";

        if ($type == "user-history") {

            $id_user = request('id_user') ?? "0";
            $data = UserCashHistory::where('id_user', $id_user)->with('transaction')->latest()->get();

            return DataTables::of($data)
                ->addColumn('created_at', function ($row) {
                    return  '<span style="display:none">' . $row->created_at . '</span>' . Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
                })
                ->addColumn('amount', function ($row) {
                    $amount = $row->amount;
                    return '<span class="' . ($amount < 0 ? 'text-danger' : ($amount > 0 ? 'text-info' : '')) . '">' . number_format($amount, 2, ',', '.') . '</span>';
                })
                ->addColumn('previous_balance', function ($row) {
                    $amount = $row->previous_balance;
                    return '<span class="' . ($amount < 0 ? 'text-danger' : ($amount > 0 ? 'text-info' : '')) . '">' . number_format($amount, 2, ',', '.') . '</span>';
                })
                ->addColumn('current_balance', function ($row) {
                    $amount = $row->current_balance;
                    return '<span class="' . ($amount < 0 ? 'text-danger' : ($amount > 0 ? 'text-info' : '')) . '">' . number_format($amount, 2, ',', '.') . '</span>';
                })
                ->addColumn('description', function ($row) {
                    return ($row->transaction ? $row->transaction->description : ($row->id_batch ? '<span class="text-info">Lote ' . $row->id_batch . "</spam>" : ''));
                })
                ->addIndexColumn()
                ->rawColumns(['created_at', 'amount', 'previous_balance', 'current_balance', 'description'])
                ->make(true);
        } else {

            $data = User::where('root', false)->with('user_cash')->latest()->get();
            $id_field = request('id-field') ?: 'id';

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) use ($id_field) {
                    $edit_route = route(request('route') ?: 'users.show', [$id_field => $row->id_user]);
                    $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-warning btn-sm"><i class="glyphicons glyphicons-edit"></i></a>';
                    return $actionBtn;
                })
                ->addColumn('amount', function ($row) {
                    $amount = 0;
                    if ($row->user_cash) {
                        $amount = $row->user_cash->amount;
                    }
                    return number_format($amount, 2, ',', '.');
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
}
