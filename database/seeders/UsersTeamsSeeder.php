<?php

namespace Database\Seeders;

use App\Models\AuthorizationType;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use App\Models\UserTeam;
use App\Models\UserAuthorizationType;
use App\Models\User;

class UsersTeamsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 60; $i++) {
            try {
                $id_user_parent = User::all()->random()['id_user'];
                $id_user_child = User::all()->random()['id_user'];

                $user_team = UserTeam::create([
                    'id_user_parent' => $id_user_parent,
                    'id_user_child' => $id_user_child,
                ]);

                $id_user_team = $user_team['id_user_team'];
                $count = mt_rand(0, AuthorizationType::count());

                for ($j = 0; $j <= $count; $j++) {
                    UserAuthorizationType::create([
                        'id_user_team' => $id_user_team,
                        'id_user_parent' => $id_user_parent,
                        'id_user_child' => $id_user_child,
                        'id_authorization_type' => AuthorizationType::all()->random()['id_authorization_type'],
                    ]);
                }
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
