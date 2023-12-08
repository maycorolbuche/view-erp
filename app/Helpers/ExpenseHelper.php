<?php

namespace App\Helpers;

use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Models\Batch;
use App\Models\UserDiscount;
use App\Models\BatchDiscount;
use App\Helpers\HolidayHelper;
use App\Helpers\DiscountHelper;

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
        //Cria o lote
        $batch = Batch::create($data);

        //Obtém as despesas
        $expenses = Expense::with(['user', 'payment_method'])
            ->where(['id_user' => $batch->id_user])
            ->whereNull('id_batch')
            ->whereIn('id_expense', $data['expense'])
            ->get();

        //Marca o lote nas despesas
        Expense::whereIn('id_expense', $expenses->pluck('id_expense')->toArray())
            ->update(['id_batch' => $batch->id_batch]);

        //Obtém os descontos deste usuário
        $discounts = UserDiscount::with([
            'discount',
            'discount.discounts_categories'
        ])->where('id_user', $batch->id_user)->get();

        BatchDiscount::where('id_batch', $batch->id_batch)->delete();

        if ($discounts->count() > 0) {

            $batches_discounts = [];
            $balance = [];

            //Percorre as despesas para verificar eventuais descontos
            foreach ($expenses as $expense) {
                //Não é Fim de Semana?
                $w =  date('w', strtotime($expense->date));
                if ($w == 0 | $w == 6) {
                    continue;
                }

                //Não é Feriado?
                $holyday = HolidayHelper::date($expense->date, $expense->user->id_branch);
                if (count($holyday) > 0) {
                    continue;
                }

                //É reembolsável?
                if (!$expense->payment_method->refundable) {
                    continue;
                }

                //Filtra pelos descontos que tem a categoria da despesa
                $filter = $discounts->filter(function ($user_discount) use ($expense) {
                    return $user_discount->discount->discounts_categories->filter(function ($category) use ($expense) {
                        return $category->id_category == $expense->id_category;
                    })->count() > 0;
                });

                if ($filter->count() <= 0) {
                    continue;
                }

                $date = $expense->date;
                if (!isset($batches_discounts[$date])) {
                    $batches_discounts[$date] = [];
                }

                foreach ($filter as $item) {
                    $id_expense = $expense->id_expense;
                    $id_discount = $item->id_discount;
                    if (!isset($batches_discounts[$date][$id_discount])) {
                        $batches_discounts[$date][$id_discount] = [];
                    }


                    $i = count($batches_discounts[$date][$id_discount]);

                    $balance[$id_expense] = $balance[$id_expense] ?? $expense->amount;

                    $ref_amount = DiscountHelper::amount($id_discount, $date);
                    $amount = $ref_amount;
                    if ($i > 0) {
                        foreach ($batches_discounts[$date][$id_discount] as $ex) {
                            $amount -= $ex['amount'] ?? 0;
                        }
                    }

                    if ($amount > $balance[$id_expense]) {
                        $amount = $balance[$id_expense];
                    }

                    $expense_amount_prev = $balance[$id_expense];
                    $expense_amount_cur = $balance[$id_expense] - $amount;
                    $batches_discounts[$date][$id_discount][$i]['id_batch'] = $batch->id_batch;
                    $batches_discounts[$date][$id_discount][$i]['id_expense'] = $id_expense;
                    $batches_discounts[$date][$id_discount][$i]['id_discount'] = $id_discount;
                    $batches_discounts[$date][$id_discount][$i]['ref_amount'] = $ref_amount;
                    $batches_discounts[$date][$id_discount][$i]['ref_date'] = $date;
                    $batches_discounts[$date][$id_discount][$i]['expense_amount'] = $expense->amount;
                    $batches_discounts[$date][$id_discount][$i]['expense_amount_prev'] = $expense_amount_prev;
                    $batches_discounts[$date][$id_discount][$i]['amount'] = $amount;
                    $batches_discounts[$date][$id_discount][$i]['expense_amount_cur'] = $expense_amount_cur;

                    $balance[$id_expense] = $expense_amount_cur;
                }
            }

            foreach ($batches_discounts as $dates) {
                $i = 1;
                foreach ($dates as $discounts) {
                    foreach ($discounts as $discount) {
                        $discount['sequence'] = $i;
                        BatchDiscount::create($discount);
                        $i++;
                    }
                }
            }
        }


        //Altera o lote com as informações das despesas
        $amount = $expenses->sum('amount');
        $refundable_amount = $expenses->filter(function ($expense) {
            return $expense->payment_method->refundable == 1;
        })->sum('amount');
        $non_refundable_amount = $expenses->filter(function ($expense) {
            return $expense->payment_method->refundable == 0;
        })->sum('amount');
        $discount = BatchDiscount::where('id_batch', $batch->id_batch)->sum('amount');

        $refund_amount = $refundable_amount - $discount;

        $batch->update([
            'expenses_count' => $expenses->count(),
            'amount' => $amount,
            'refundable_amount' => $refundable_amount,
            'non_refundable_amount' => $non_refundable_amount,
            'discount' => $discount,
            'refund_amount' => $refund_amount,
        ]);

        return $batch->id_batch;
    }
}
