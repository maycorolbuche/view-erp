<?php

namespace App\Helpers;

use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Models\Batch;

class ExpenseHelper
{
    public static function refresh($id)
    {
        $expense = Expense::with(['clients', 'users'])->find($id);

        ExpenseDetail::where('id_expense', $expense->id_expense)->delete();

        foreach ($expense->clients as $client) {
            $total_amount = $client->pivot->amount;
            $accumulated_amount = 0;
            foreach ($expense->users as $key => $user) {
                $amount = round($total_amount * $user->pivot->percentage / 100, 2);
                if ($key + 1 >= count($expense->users)) {
                    $amount = $total_amount - $accumulated_amount;
                }

                $percentage = $amount / $total_amount * 100;

                ExpenseDetail::create([
                    'id_expense' => $expense->id_expense,
                    'id_expense_user' => $user->pivot->id_expense_user,
                    'id_user' => $user->id_user,
                    'id_expense_client' => $client->pivot->id_expense_client,
                    'id_client' => $client->id_client,
                    'amount' => $amount,
                    'percentage' => $percentage,
                ]);

                $accumulated_amount += $amount;
            }
        }
    }

    public static function batch($data)
    {
        $batch = Batch::create($data);
        $expenses = Expense::with('payment_method')
            ->where(['id_user' => $batch->id_user])
            ->whereNull('id_batch')
            ->whereIn('id_expense', $data['expense'])
            ->get();

        Expense::whereIn('id_expense', $expenses->pluck('id_expense')->toArray())
            ->update(['id_batch' => $batch->id_batch]);

        $batch->update([
            'expenses_count' => $expenses->count(),
            'amount' => $expenses->sum('amount'),
            'refundable_amount' => $expenses->filter(function ($expense) {
                return $expense->payment_method->refundable == 1;
            })->sum('amount'),
            'non_refundable_amount' => $expenses->filter(function ($expense) {
                return $expense->payment_method->refundable == 0;
            })->sum('amount'),
        ]);

        return $batch->id_batch;
    }
}
