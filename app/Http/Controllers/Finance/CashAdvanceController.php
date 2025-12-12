<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCashHistory;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Helpers\DataTableHelper;

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
            return DataTableHelper::users_cash_history(UserCashHistory::user($id_user));
        } else {
            return DataTableHelper::users_cash();
        }
    }
}
