<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Client;
use App\Models\Authorization;
use App\Models\AuthorizationType;
use App\Models\AuthorizationClient;
use App\Models\AuthorizationStatus;

class AuthorizationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; $i++) {
            try {
                $start_datetime = $faker->dateTimeBetween('-1 month', 'now');
                $end_datetime = $faker->dateTimeBetween($start_datetime, '+1 month');

                $authorization = Authorization::create([
                    'id_user' => ($i == 1 ? 1 : User::all()->random()['id_user']),
                    'id_authorization_type' => ($i == 1 ? 1 : AuthorizationType::all()->random()['id_authorization_type']),
                    'description' => $faker->text,
                    'start_datetime' => $start_datetime,
                    'end_datetime' => $end_datetime,
                    'active' => 1,
                    'approved' => 1,
                ]);

                $id_authorization = $authorization['id_authorization'];

                $count = mt_rand(1, 5);
                for ($j = 0; $j <= $count; $j++) {
                    AuthorizationClient::create([
                        'id_authorization' => $id_authorization,
                        'id_client' => Client::all()->random()['id_client'],
                    ]);
                }

                $count = mt_rand(1, 5);
                for ($j = 0; $j <= $count; $j++) {
                    AuthorizationStatus::create([
                        'id_authorization' => $id_authorization,
                        'id_user' => User::all()->random()['id_user'],
                        'approved' => 1,
                    ]);
                }
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
