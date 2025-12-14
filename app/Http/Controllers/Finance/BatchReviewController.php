<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Expense;
use App\Helpers\UserHelper;
use App\Helpers\ConfigHelper;
use App\Helpers\CalendarHelper;
use App\Helpers\DataTableHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BatchNotification;

class BatchReviewController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('batch-review.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Batch::with('expenses')
            ->reviewPending()
            ->where('id_batch', $id)
            ->first();
        if ($data) {
            $user_cash = UserHelper::getCash($data->id_user);
            $estimated_payment_date = CalendarHelper::addBusinessDays(now(), ConfigHelper::get('batches.standard_payment_days'), auth()->user()->id_branch);

            return view('batch-review.index', compact('data', 'user_cash', 'estimated_payment_date'));
        } else {
            return redirect()->route('batch-review')->with('error', 'Registro não encontrado!');
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
            $batch = Batch::reviewPending()
                ->where('id_batch', $id)
                ->first();
            if ($batch) {
                if ($batch->revised_status == 'pending') {
                    $data = [
                        'revised_by' => auth()->user()->id_user,
                        'revised_at' => now(),
                        'revised_status' => 'analyzing'
                    ];

                    $batch->update($data);

                    return redirect()->route('batch-review.show', ['id' => $id]);
                } elseif ($request->input('_action') == "fail") {
                    $data = [
                        'revised_by' => auth()->user()->id_user,
                        'revised_at' => now(),
                        'revised_status' => 'pending'
                    ];

                    $batch->update($data);
                    $this->sendMail($id);

                    return redirect()->route('batch-review.show', ['id' => $id]);
                } elseif ($request->input('_action') == "revised") {

                    $expense = Expense::batch($id)->where('id_expense', $request->input("id_expense"));
                    if (!$expense) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Despesa não encontrada no batch especificado.',
                            'errors' => [
                                'expense_id' => ['A despesa informada não pertence a este lote ou não existe.']
                            ]
                        ], 404);
                    }

                    $data = [
                        'revised_by' => auth()->user()->id_user,
                        'revised_at' => now(),
                        'revised' => $request->input("revised", false)
                    ];

                    $expense->update($data);

                    return response()->json([
                        'success' => true,
                        'message' => 'Despesa alterada com sucesso.',
                    ]);
                } elseif ($request->input('_action') == "approve") {

                    if ($batch->refundable_amount <= 0) {
                        $data = [
                            'revised_by' => auth()->user()->id_user,
                            'revised_at' => now(),
                            'revised_status' => 'approved',
                            'active' => false,
                            'user_cash' => 0,
                            'amount_paid' => 0,
                        ];

                        $batch->update($data);
                        $this->sendMail($id);

                        return redirect()->route('batch-review')->with('success', 'Lote fechado com sucesso!');
                    } else {
                        $data = [
                            'revised_by' => auth()->user()->id_user,
                            'revised_at' => now(),
                            'revised_status' => 'approved',
                            'estimated_payment_date' => $request->input("estimated_payment_date")
                        ];

                        $batch->update($data);
                        $this->sendMail($id);

                        return redirect()->route('batch-review')->with('success', 'Lote aprovado para pagamento!');
                    }
                }

                return redirect()->route('batch-review')->with('error', 'Ação não definida!');
            } else {
                return redirect()->route('batch-review')->with('error', 'Registro não encontrado!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function datatable()
    {
        return DataTableHelper::batches(Batch::reviewPending());
    }

    public function sendMail($id_batch)
    {
        $batch = Batch::with('user')->find($id_batch);
        Notification::send($batch->user, new BatchNotification($batch, 'user'));
    }
}
