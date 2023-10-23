<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\System;
use App\Models\Permission;
use App\Models\Profile;
use App\Models\Route;
use App\Models\UserSystem;
use Illuminate\Database\QueryException;

class Root
{

    public static function run()
    {
        //Adiciona as rota "root" para os sistemas "root"
        $routes = Route::select(['id_route', 'permissions'])->where('root', true)->get();
        $systems = System::select('id_system')->where('root', true)->get();
        foreach ($systems as $system) {
            foreach ($routes as $route) {
                $permission = Permission::where([
                    'id_route' => $route->id_route,
                    'id_system' => $system->id_system,
                    'id_user' => null,
                    'id_profile' => null,
                ])->first();
                if ($permission == null) {
                    Permission::create([
                        'id_route' => $route->id_route,
                        'id_system' => $system->id_system,
                        'permissions' => $route->permissions,
                    ]);
                } else {
                    Permission::where('id_route', $route->id_route)
                        ->where('id_system', $system->id_system)
                        ->where('id_user', null)
                        ->where('id_profile', null)
                        ->update([
                            'permissions' => $route->permissions,
                        ]);
                }
            }
        }


        //Verifica as permissões
        $users = User::select(['id_user', 'root'])->get();
        $systems = System::select('id_system')->get();

        foreach ($systems as $system) {

            //Verifica as rotas que esse sistema tem acesso
            $routes = Permission::select(['id_route', 'permissions'])->where(['id_system' => $system->id_system, 'id_user' => null, 'id_profile' => null])->get();
            $routes_ids = array_map(function ($route) {
                return $route['id_route'];
            }, $routes->toArray());

            //Apaga as permissões dos usuarios e dos perfis que o sistema não tem acesso
            Permission::where('id_system', $system->id_system)->whereNotIn('id_route', $routes_ids)->where(function ($query) {
                $query->whereNotNull('id_user')->orWhereNotNull('id_profile');
            })->delete();

            foreach ($users as $user) {
                foreach ($routes  as $route) {
                    if ($user->root == true) {
                        try {
                            Permission::create([
                                'id_route' => $route->id_route,
                                'id_system' => $system->id_system,
                                'id_user' => $user->id_user,
                                'permissions' => $route->permissions,
                            ]);
                        } catch (QueryException $e) {
                            Permission::where('id_route', $route->id_route)
                                ->where('id_system', $system->id_system)
                                ->where('id_user', $user->id_user)
                                ->update([
                                    'permissions' => $route->permissions,
                                ]);
                        }
                    } else {
                        $permission = Permission::select('permissions')
                            ->where('id_route', $route->id_route)
                            ->where('id_system', $system->id_system)
                            ->where('id_user', $user->id_user)
                            ->first();
                        if ($permission != null) {
                            $res = array_values(array_intersect($permission['permissions'], $route->permissions));
                            Permission::select('permissions')
                                ->where('id_route', $route->id_route)
                                ->where('id_system', $system->id_system)
                                ->where('id_user', $user->id_user)
                                ->update([
                                    'permissions' => $res
                                ]);
                        }
                    }
                }

                if ($user->root == true) {
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

            $profiles = Profile::select(['id_profile', 'root'])->where('id_system', $system->id_system)->get();
            foreach ($profiles as $profile) {
                foreach ($routes  as $route) {
                    if ($profile->root == true) {
                        try {
                            Permission::create([
                                'id_route' => $route->id_route,
                                'id_system' => $system->id_system,
                                'id_profile' => $profile->id_profile,
                                'permissions' => $route->permissions,
                            ]);
                        } catch (QueryException $e) {
                            Permission::where('id_route', $route->id_route)
                                ->where('id_system', $system->id_system)
                                ->where('id_profile', $profile->id_profile)
                                ->update([
                                    'permissions' => $route->permissions,
                                ]);
                        }
                    } else {
                        $permission = Permission::select('permissions')
                            ->where('id_route', $route->id_route)
                            ->where('id_system', $system->id_system)
                            ->where('id_profile', $profile->id_profile)
                            ->first();
                        if ($permission != null) {
                            $res = array_values(array_intersect($permission['permissions'], $route->permissions));
                            Permission::select('permissions')
                                ->where('id_route', $route->id_route)
                                ->where('id_system', $system->id_system)
                                ->where('id_profile', $profile->id_profile)
                                ->update([
                                    'permissions' => $res
                                ]);
                        }
                    }
                }
            }
        }
    }
}
