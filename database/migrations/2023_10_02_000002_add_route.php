<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Route;

class AddRoute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $all_resources = ["index",  "store", "show", "update", "destroy"];
        $all_permissions = ["store", "update", "destroy"];

        $update_resources = ["index", "update-all"];
        $update_permissions = ["update"];

        Route::create([
            'id_route_group' => 1,
            'label' => 'Sistemas',
            'name' => 'systems',
            'uri' => 'systems',
            'controller' => 'SystemController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-show_big_thumbnails',
            'sequence' => 10,
            'root' => 1,
        ]);
        Route::create([
            'id_route_group' => 1,
            'label' => 'Acessos Sistemas',
            'name' => 'systems-permissions',
            'uri' => 'systems/{pid}/permissions',
            'controller' => 'SystemPermissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicon glyphicon-th-list',
            'sequence' => 20,
            'root' => 1,
        ]);
        Route::create([
            'id_route_group' => 2,
            'label' => 'Perfis',
            'name' => 'profiles',
            'uri' => 'profiles',
            'controller' => 'ProfileController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-id-card-alt',
            'sequence' => 60,
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => 2,
            'label' => 'Acessos Perfis',
            'name' => 'profiles-permissions',
            'uri' => 'profiles/{pid}/permissions',
            'controller' => 'ProfilePermissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicons glyphicons-vcard',
            'sequence' => 70,
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => 2,
            'label' => 'Usuários',
            'name' => 'users-access',
            'uri' => 'users/{pid}/access',
            'controller' => 'UserAccessController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-users',
            'sequence' => 30,
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => 2,
            'label' => 'Perfis Usuários',
            'name' => 'users-profiles',
            'uri' => 'users/{pid}/profiles',
            'controller' => 'UserProfileController',
            'resources' => $all_resources,
            'permissions' => $all_resources,
            'icon' => 'fas fa-address-card',
            'sequence' => 40,
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => 2,
            'label' => 'Acessos Usuários',
            'name' => 'users-permissions',
            'uri' => 'users/{pid}/permissions',
            'controller' => 'UserPermissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-user-tag',
            'sequence' => 50,
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => 3,
            'label' => 'Pessoas',
            'name' => 'users',
            'uri' => 'users',
            'controller' => 'UserController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-user-friends',
            'sequence' => 100,
            'root' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Route::truncate();
    }
}
