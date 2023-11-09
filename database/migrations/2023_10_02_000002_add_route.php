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
            'controller' => 'System\SystemController',
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
            'controller' => 'System\SystemPermissionController',
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
            'controller' => 'User\UserAccessController',
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
            'controller' => 'User\UserSystemController',
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
            'controller' => 'User\UserProfileController',
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
            'controller' => 'User\UserPermissionController',
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
            'controller' => 'Profile\ProfileController',
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
            'controller' => 'Profile\ProfilePermissionController',
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
            'controller' => 'User\UserController',
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
            'controller' => 'User\UserPhoneController',
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
            'controller' => 'User\UserAddressController',
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
            'controller' => 'User\UserTeamController',
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
            'controller' => 'User\UserDependentController',
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
            'controller' => 'User\UserAdmissionController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-id-card-alt',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Cargos/Funções',
            'name' => 'users-roles',
            'uri' => 'users/{pid}/roles',
            'controller' => 'User\UserRoleController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-tie',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Férias',
            'name' => 'users-vacations',
            'uri' => 'users/{pid}/vacations',
            'controller' => 'User\UserVacationController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-airplane',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Pagamentos',
            'name' => 'users-payments',
            'uri' => 'users/{pid}/payments',
            'controller' => 'User\UserPaymentController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-money-bill-wave',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Previdência',
            'name' => 'users-pension',
            'uri' => 'users/{pid}/pension',
            'controller' => 'User\UserPensionController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fa fa-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Especializações',
            'name' => 'users-certifications',
            'uri' => 'users/{pid}/certifications',
            'controller' => 'User\UserCertificationController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-certificate',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Atestados',
            'name' => 'users-sick-leaves',
            'uri' => 'users/{pid}/sick-leaves',
            'controller' => 'User\UserSickLeaveController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-notes-medical',
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
