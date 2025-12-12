<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Transaction;
use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use App\Helpers\DataTableHelper;

class BatchPaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('batch-payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Batch::paymentPending()->where('id_batch', $id)->first();
        if ($data) {
            $user_cash = UserHelper::getCash($data->id_user);
            return view('batch-payments.index', compact('data', 'user_cash'));
        } else {
            return redirect()->route('batch-payments')->with('error', 'Registro não encontrado!');
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
            $batch = Batch::paymentPending()->where('id_batch', $id)->first();
            if ($batch) {
                $user_cash = UserHelper::getCash($batch->id_user);
                $amount_paid = $batch->refund_amount;
                $discount = 0;
                if ($user_cash > 0) {
                    $discount = min($user_cash, $amount_paid);
                    $amount_paid = $amount_paid - $discount;

                    UserHelper::removeCash($batch->id_user, $discount, [
                        'id_batch' => $id,
                    ], false);
                }

                $batch->update([
                    'payment_date' => date('Y-m-d'),
                    'user_cash' => $discount,
                    'amount_paid' => $amount_paid,
                    'active' => false,
                ]);

                Transaction::where(['id_batch' => $id, 'type' => 'batch-payment'])->delete();
                Transaction::create([
                    'type' => 'batch-payment',
                    'id_batch' => $id,
                    'id_user' => $batch->id_user,
                    'date' => date("Y-m-d"),
                    'amount' => $amount_paid * -1,
                    'description' => 'Pagamento de Lote',
                ]);

                return redirect()->route('batch-payments')->with('success', 'Pagamento registrado com sucesso');
            } else {
                return redirect()->route('batch-payments')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::batches(Batch::paymentPending());
    }
}
