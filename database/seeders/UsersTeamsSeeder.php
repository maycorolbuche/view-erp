<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\UserTeam;
use App\Models\User;

class UsersTeamsSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 60; $i++) {
            try {
                UserTeam::create([
                    'id_user_parent' => User::all()->random()['id_user'],
                    'id_user_child' => User::all()->random()['id_user'],
                    'authorizations' => [],
                ]);
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
