<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Route;

class AddRoute extends Migration
{
    private static $sequenceValue = 0;

    public function sequence()
    {
        return ++self::$sequenceValue;
    }
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


        /* PARAMETRIZAÇÃO */
        $id_route_group = 1;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Sistemas',
            'name' => 'systems',
            'uri' => 'systems',
            'controller' => 'SystemController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-show_big_thumbnails',
            'sequence' => self::sequence(),
            'root' => 1,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Acessos Sistemas',
            'name' => 'systems-permissions',
            'uri' => 'systems/{pid}/permissions',
            'controller' => 'SystemPermissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicon glyphicon-th-list',
            'sequence' => self::sequence(),
            'root' => 1,
        ]);

        /* USUÁRIOS E ACESSOS */
        $id_route_group = 2;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Usuários',
            'name' => 'users-access',
            'uri' => 'users/{pid}/access',
            'controller' => 'UserAccessController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-users',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Sistemas Usuários',
            'name' => 'users-systems',
            'uri' => 'users/{pid}/systems',
            'controller' => 'UserSystemController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-user-cog',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Perfis Usuários',
            'name' => 'users-profiles',
            'uri' => 'users/{pid}/profiles',
            'controller' => 'UserProfileController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-address-card',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Acessos Usuários',
            'name' => 'users-permissions',
            'uri' => 'users/{pid}/permissions',
            'controller' => 'UserPermissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-user-tag',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Perfis',
            'name' => 'profiles',
            'uri' => 'profiles',
            'controller' => 'ProfileController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-id-card-alt',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Acessos Perfis',
            'name' => 'profiles-permissions',
            'uri' => 'profiles/{pid}/permissions',
            'controller' => 'ProfilePermissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicons glyphicons-vcard',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);

        /* PESSOAS */
        $id_route_group = 3;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Pessoas',
            'name' => 'users',
            'uri' => 'users',
            'controller' => 'UserController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-user',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Telefones',
            'name' => 'users-phones',
            'uri' => 'users/{pid}/phones',
            'controller' => 'UserPhoneController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-phone',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Endereços',
            'name' => 'users-address',
            'uri' => 'users/{pid}/address',
            'controller' => 'UserAddressController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-address-book',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Equipe',
            'name' => 'users-teams',
            'uri' => 'users/{pid}/teams',
            'controller' => 'UserTeamController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-users',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Dependentes',
            'name' => 'users-dependents',
            'uri' => 'users/{pid}/dependents',
            'controller' => 'UserDependentController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-child',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Admissão/Sociedade',
            'name' => 'users-admission',
            'uri' => 'users/{pid}/admission',
            'controller' => 'UserAdmissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-id-card-alt',
            'sequence' => self::sequence(),
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
        try {
            Route::truncate();
        } catch (Exception $e) {
        }
    }
}
