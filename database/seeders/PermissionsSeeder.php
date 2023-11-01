<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\System;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {

        $routes = Route::select(['id_route', 'permissions'])->get();
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
    }
}
