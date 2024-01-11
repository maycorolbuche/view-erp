<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\UserCash;
use App\Models\UserCashHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;

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
        $data = Batch::where(['id_batch' => $id, 'active' => true])->first();
        if ($data) {
            $user_cash = UserCash::where('id_user', $data->id_user)->first();
            if (!$user_cash) {
                $user_cash = new \stdClass();
                $user_cash->amount = 0;
            }

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
            $batch = Batch::where(['id_batch' => $id, 'active' => true])->first();
            if ($batch) {
                $user_cash = UserCash::where('id_user', $batch->id_user)->first();
                if (!$user_cash) {
                    $user_cash = new \stdClass();
                    $user_cash->amount = 0;
                }

                $user_cash_amount = $user_cash->amount ?? 0;
                $amount_paid = $batch->refund_amount;
                $discount = 0;
                if ($user_cash_amount > 0) {
                    $discount = min($user_cash_amount, $amount_paid);
                    $amount_paid = $amount_paid - $discount;

                    $user_cash_history = UserCashHistory::where('id_batch', $id)->first();
                    if (!$user_cash_history) {
                        $previous_balance = UserCashHistory::where('id_user', $batch->id_user)->sum('amount');
                        $current_balance = $user_cash_amount;
                        /*
                        Transaction::where(['id_batch' => $id, 'type' => 'cash-advance-batch'])->delete();
                        $transaction = Transaction::create([
                            'type' => 'cash-advance-return',
                            'id_batch' => $id,
                            'id_user' => $batch->id_user,
                            'amount' => $discount,
                            'description' => 'Adiantamento Utilizado',
                        ]);
                        */
                        UserCashHistory::create([
                            'id_batch' => $id,
                            'id_user' => $batch->id_user,
                            'amount' => $discount * -1,
                            'previous_balance' => $previous_balance,
                            'current_balance' => $current_balance - $discount,
                        ]);

                        UserCash::where('id_user', $batch->id_user)->delete();
                        if ($current_balance - $discount > 0) {
                            UserCash::create([
                                'id_user' => $batch->id_user,
                                'amount' => $current_balance - $discount,
                            ]);
                        }
                    }
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
        $data = Batch::with(['user'])
            ->where('active', true)
            ->latest()->get();
        $id_field = request('id-field') ?: 'id';

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) use ($id_field) {
                $edit_route = route(request('route') ?: 'me-batches.show', [$id_field => $row->id_batch]);
                $actionBtn = '<a href="' . $edit_route . '" class="edit btn btn-success btn-sm"><i class="fas fa-hand-holding-usd"></i></a>';
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
            ->rawColumns(['actions', 'created_at', 'refundable_amount', 'non_refundable_amount', 'amount', 'active'])
            ->make(true);
    }
}
