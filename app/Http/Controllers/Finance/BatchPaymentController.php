<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\UserCash;
use App\Models\UserCashHistory;
use App\Models\Transaction;
use App\Helpers\UserHelper;
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
            $batch = Batch::where(['id_batch' => $id, 'active' => true])->first();
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
