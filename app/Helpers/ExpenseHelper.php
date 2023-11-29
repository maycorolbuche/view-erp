<?php

namespace App\Helpers;

use App\Models\Expense;
use App\Models\ExpenseDetail;

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
}
