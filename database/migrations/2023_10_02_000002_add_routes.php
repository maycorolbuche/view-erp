<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Route;

class AddRoutes extends Migration
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

        $store_resources = ["index",  "store"];
        $store_permissions = ["store"];

        $update_all_resources = ["index", "update-all"];
        $update_resources = ["index", "show", "update"];
        $update_permissions = ["update"];

        $query_resources = ["index",  "show"];
        $query_permissions = [];


        /* SISTEMAS */
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
            'resources' => $update_all_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicon glyphicon-th-list',
            'sequence' => self::sequence(),
            'root' => 1,
        ]);

        /* PARAMETRIZAÇÃO */
        $id_route_group = 2;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Configurações Gerais',
            'name' => 'configs',
            'uri' => 'configs',
            'controller' => 'Config\ConfigController',
            'resources' => $update_all_resources,
            'permissions' => $update_permissions,
            'icon' => 'fa fa-cogs',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Clientes',
            'name' => 'clients',
            'uri' => 'clients',
            'controller' => 'Client\ClientController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-building',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Filiais',
            'name' => 'branches',
            'uri' => 'branches',
            'controller' => 'Branch\BranchController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-building',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Feriados',
            'name' => 'holidays',
            'uri' => 'holidays',
            'controller' => 'Holiday\HolidayController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-calendar-day',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Cargos',
            'name' => 'roles',
            'uri' => 'roles',
            'controller' => 'Role\RoleController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-user-secret',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Estados Civis',
            'name' => 'civil-statuses',
            'uri' => 'civil-statuses',
            'controller' => 'CivilStatus\CivilStatusController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-user-circle',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Formas de Pagamento',
            'name' => 'payment-methods',
            'uri' => 'payment-methods',
            'controller' => 'PaymentMethod\PaymentMethodController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fa fa-credit-card',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Vínculos Trabalho',
            'name' => 'employment-types',
            'uri' => 'employment-types',
            'controller' => 'EmploymentType\EmploymentTypeController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'far fa-id-card',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Operadoras Telefonia',
            'name' => 'carriers',
            'uri' => 'carriers',
            'controller' => 'Carrier\CarrierController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-sim-card',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Tipos de Telefones',
            'name' => 'phones-types',
            'uri' => 'phones-types',
            'controller' => 'PhoneType\PhoneTypeController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fa fa-phone-square',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Graus Relacionamento',
            'name' => 'relationships-degrees',
            'uri' => 'relationships-degrees',
            'controller' => 'RelationshipDegree\RelationshipDegreeController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'glyphicons glyphicons-woman',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Tipos de Autorização',
            'name' => 'authorizations-types',
            'uri' => 'authorizations-types',
            'controller' => 'Authorization\AuthorizationTypeController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-file-alt',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Categorias',
            'name' => 'categories',
            'uri' => 'categories',
            'controller' => 'Category\CategoryController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-ticket-alt',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Descontos',
            'name' => 'discounts',
            'uri' => 'discounts',
            'controller' => 'Discount\DiscountController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-comment-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Valores Descontos',
            'name' => 'discounts-amounts',
            'uri' => 'discounts/{pid}/amounts',
            'controller' => 'Discount\DiscountAmountController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-funnel-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);

        /* USUÁRIOS E ACESSOS */
        $id_route_group = 3;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Usuários',
            'name' => 'users-access',
            'uri' => 'users/{pid}/access',
            'controller' => 'User\UserAccessController',
            'resources' => $update_all_resources,
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
            'resources' => $update_all_resources,
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
            'resources' => $update_all_resources,
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
            'resources' => $update_all_resources,
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
            'resources' => $update_all_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicons glyphicons-vcard',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);

        /* PESSOAS */
        $id_route_group = 4;
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
            'resources' => $update_all_resources,
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
            'resources' => $update_all_resources,
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
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Advertências',
            'name' => 'users-warnings',
            'uri' => 'users/{pid}/warnings',
            'controller' => 'User\UserWarningController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fa fa-warning',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Descontos Lote',
            'name' => 'users-discounts',
            'uri' => 'users/{pid}/discounts',
            'controller' => 'User\UserDiscountController',
            'resources' => $update_all_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicons glyphicons-database_minus',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Notificações',
            'name' => 'users-notifications',
            'uri' => 'users/{pid}/notifications',
            'controller' => 'User\UserNotificationController',
            'resources' => $update_all_resources,
            'permissions' => $update_permissions,
            'icon' => 'glyphicons glyphicons-message_new',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);


        /* DESPESAS */
        $id_route_group = 5;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Solicitação de Despesas',
            'name' => 'authorizations-expenses',
            'uri' => 'authorizations-expenses',
            'controller' => 'Authorization\AuthorizationExpenseController',
            'resources' => $store_resources,
            'permissions' => $store_permissions,
            'icon' => 'fas fa-money-check',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Cadastro de Despesas',
            'name' => 'expenses',
            'uri' => 'expenses',
            'controller' => 'Expense\ExpenseController',
            'resources' => $all_resources,
            'permissions' => $all_permissions,
            'icon' => 'fas fa-hand-holding-usd',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Solic. Adiantamento',
            'name' => 'authorizations-cash-advances',
            'uri' => 'authorizations-cash-advances',
            'controller' => 'Authorization\AuthorizationCashAdvanceController',
            'resources' => $store_resources,
            'permissions' => $store_permissions,
            'icon' => 'fas fa-money-check-alt',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Dev. Adiantamento',
            'name' => 'authorizations-cash-advance-returns',
            'uri' => 'authorizations-cash-advance-returns',
            'controller' => 'Authorization\AuthorizationCashAdvanceReturnController',
            'resources' => $store_resources,
            'permissions' => $store_permissions,
            'icon' => 'fas fa-money-check-alt',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Gerar Lote',
            'name' => 'batches',
            'uri' => 'batches',
            'controller' => 'Batch\BatchController',
            'resources' => $store_resources,
            'permissions' => $store_permissions,
            'icon' => 'fas fa-database',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);


        /* FINANCEIRO */
        $id_route_group = 7;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Pagamentos de Lotes',
            'name' => 'batch-payments',
            'uri' => 'batch-payments',
            'controller' => 'Finance\BatchPaymentController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fa fa-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Adiantamentos',
            'name' => 'cash-advances',
            'uri' => 'cash-advances',
            'controller' => 'Finance\CashAdvanceController',
            'resources' => $update_resources,
            'permissions' => $update_permissions,
            'icon' => 'fas fa-comment-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Fluxo de Caixa',
            'name' => 'cash-flow',
            'uri' => 'cash-flow',
            'controller' => 'Finance\CashFlowController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'fas fa-file-invoice-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);


        /* CONSULTAS */
        $id_route_group = 6;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Autorizações',
            'name' => 'queries-authorizations',
            'uri' => 'queries/authorizations',
            'controller' => 'Query\AuthorizationController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'fab fa-searchengin',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Despesas',
            'name' => 'queries-expenses',
            'uri' => 'queries/expenses',
            'controller' => 'Query\ExpenseController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'fas fa-search-dollar',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Lotes',
            'name' => 'queries-batches',
            'uri' => 'queries/batches',
            'controller' => 'Query\BatchController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'fas fa-database',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);


        /* RELATÓRIOS */
        $id_route_group = 8;
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Por Usuários',
            'name' => 'reports-users',
            'uri' => 'reports/users',
            'controller' => 'Report\UserController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'fas fa-users',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Por Clientes',
            'name' => 'reports-clients',
            'uri' => 'reports/clients',
            'controller' => 'Report\ClientController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'glyphicons glyphicons-building',
            'sequence' => self::sequence(),
            'root' => 0,
        ]);
        Route::create([
            'id_route_group' => $id_route_group,
            'label' => 'Por Tipo de Despesas',
            'name' => 'reports-expenses',
            'uri' => 'reports/expenses',
            'controller' => 'Report\ExpenseController',
            'resources' => $query_resources,
            'permissions' => $query_permissions,
            'icon' => 'fas fa-hand-holding-usd',
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
