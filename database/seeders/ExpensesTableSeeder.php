<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Expense;
use App\Models\ExpenseClient;
use App\Models\ExpenseUser;
use App\Models\Category;
use App\Models\Authorization;
use App\Models\AuthorizationClient;
use App\Models\PaymentMethod;
use App\Helpers\ExpenseHelper;

class ExpensesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 100; $i++) {
            try {
                $user = User::all()->random();
                $authorization = Authorization::where('id_user', $user['id_user'])->inRandomOrder()->first();

                if ($authorization) {
                    $authorization_client = AuthorizationClient::where('id_authorization',  $authorization['id_authorization'])->inRandomOrder()->first();
                    $amount = $faker->randomFloat(2, 1, 1000);

                    $expense = Expense::create([
                        'id_user' => $user['id_user'],
                        'id_authorization' => $authorization['id_authorization'],
                        'date' => $faker->dateTimeBetween($authorization['start_date'], $authorization['end_date']),
                        'id_category' => Category::all()->random()['id_category'],
                        'id_payment_method' => PaymentMethod::all()->random()['id_payment_method'],
                        'amount' => $amount,
                        'notes' => $faker->text,
                    ]);

                    ExpenseClient::create([
                        'id_expense' => $expense['id_expense'],
                        'id_client' => $authorization_client['id_client'],
                        'amount' => $amount,
                        'percentage' => 100,
                    ]);

                    ExpenseUser::create([
                        'id_expense' => $expense['id_expense'],
                        'id_user' => $user['id_user'],
                        'amount' => $amount,
                        'percentage' => 100,
                    ]);

                    ExpenseHelper::refresh($expense['id_expense']);
                }
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
