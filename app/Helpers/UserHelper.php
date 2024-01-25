<?php

namespace App\Helpers;

use App\Models\UserCash;
use App\Models\UserCashHistory;
use App\Models\Transaction;

class UserHelper
{

    public static function getCash($id_user)
    {
        $amount = 0;

        $user_cash = UserCash::where('id_user', $id_user)->first();
        if ($user_cash) {
            $amount = $user_cash->amount ?? 0;
        }
        return $amount;
    }

    private static function setCash($id_user, $amount)
    {
        if ($amount == 0) {
            UserCash::where('id_user', $id_user)->delete();
        } else {
            UserCash::updateOrCreate(
                ['id_user' => $id_user],
                ['amount' => $amount]
            );
        }
        return $amount;
    }

    public static function addCash($id_user, $amount, $data = [], $generate_transaction = true)
    {
        $amount = abs($amount);
        $previous_balance = self::getCash($id_user);
        $current_balance = $previous_balance + $amount;

        $data['id_user'] = $id_user;
        $data['amount'] = $amount;
        $data['date'] = date("Y-m-d");
        $data['previous_balance'] = $previous_balance;
        $data['current_balance'] = $current_balance;

        if ($generate_transaction) {
            $transaction = Transaction::create([
                'type' => $data['type'] ?? 'user-cash',
                'id_authorization' => $data['id_authorization'] ?? null,
                'id_user' => $id_user,
                'date' => date("Y-m-d"),
                'amount' => $amount * -1,
                'description' => $data['description'] ?? 'Ajuste de Saldo',
            ]);

            $data['id_transaction'] = $transaction->id_transaction;
        }

        UserCashHistory::create($data);

        return self::setCash($id_user, $current_balance);
    }

    public static function removeCash($id_user, $amount, $data = [], $generate_transaction = true)
    {
        $amount = abs($amount);
        $previous_balance = self::getCash($id_user);
        $current_balance = $previous_balance - $amount;

        $data['id_user'] = $id_user;
        $data['amount'] = $amount * -1;
        $data['date'] = date("Y-m-d");
        $data['previous_balance'] = $previous_balance;
        $data['current_balance'] = $current_balance;

        if ($generate_transaction) {
            $transaction = Transaction::create([
                'type' => $data['type'] ?? 'user-cash',
                'id_authorization' => $data['id_authorization'] ?? null,
                'id_user' => $id_user,
                'date' => date("Y-m-d"),
                'amount' => $amount,
                'description' => $data['description'] ?? 'Ajuste de Saldo',
            ]);

            $data['id_transaction'] = $transaction->id_transaction;
        }

        UserCashHistory::create($data);

        return self::setCash($id_user, $current_balance);
    }
}
