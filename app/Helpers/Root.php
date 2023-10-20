<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\System;
use App\Models\Permission;
use App\Models\UserSystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;

class Root
{

    public static function run()
    {
        //Concete acesso total aos usuários root.
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return str_contains($route->uri(), '{system}/');
        })->map(function ($route) {
            $path = explode("/", $route->uri());
            return $path[1];
        })->unique();

        $users = User::select('id_user')->where('root', 1)->get();
        $systems = System::select('id_system')->get();

        foreach ($systems as $system) {
            foreach ($users as $user) {
                foreach ($routes  as $route) {
                    try {
                        Permission::create([
                            'route' => $route,
                            'id_system' => $system->id_system,
                            'id_user' => $user->id_user
                        ]);
                    } catch (QueryException $e) {
                        continue;
                    }
                }


                try {
                    UserSystem::create([
                        'id_system' => $system->id_system,
                        'id_user' => $user->id_user
                    ]);
                } catch (QueryException $e) {
                    continue;
                }
            }
        }
    }
}
