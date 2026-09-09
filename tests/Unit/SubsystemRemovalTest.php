<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SubsystemRemovalTest extends TestCase
{
    public function test_dynamic_modules_are_registered_at_the_application_root(): void
    {
        $routes = file_get_contents(__DIR__ . '/../../routes/web.php');

        $this->assertStringNotContainsString('prefix\' => $system->slug', $routes);
        $this->assertStringNotContainsString("middleware' => ['system']", $routes);
        $this->assertStringContainsString('Route::get($route->uri . \'/datatable\'', $routes);
    }

    public function test_runtime_permission_code_has_no_system_scope(): void
    {
        $files = [
            __DIR__ . '/../../app/Http/Middleware/Access.php',
            __DIR__ . '/../../app/Http/Middleware/LoadPermissions.php',
            __DIR__ . '/../../app/Models/Permission.php',
            __DIR__ . '/../../app/Models/Profile.php',
            __DIR__ . '/../../app/Http/Controllers/User/UserPermissionController.php',
            __DIR__ . '/../../app/Http/Controllers/Profile/ProfilePermissionController.php',
        ];

        foreach ($files as $file) {
            $this->assertStringNotContainsString('id_system', file_get_contents($file), $file);
        }
    }

    public function test_permission_middleware_uses_existing_authorization_helper(): void
    {
        $middleware = file_get_contents(__DIR__ . '/../../app/Http/Middleware/LoadPermissions.php');

        $this->assertStringContainsString('AuthorizationHelper::pending_count()', $middleware);
        $this->assertStringNotContainsString('Authorization::getPendingResponseCount()', $middleware);
    }

    public function test_obsolete_system_runtime_artifacts_were_removed(): void
    {
        $this->assertFileDoesNotExist(__DIR__ . '/../../app/Models/System.php');
        $this->assertFileDoesNotExist(__DIR__ . '/../../app/Models/UserSystem.php');
        $this->assertFileDoesNotExist(__DIR__ . '/../../app/Http/Middleware/System.php');
        $this->assertDirectoryDoesNotExist(__DIR__ . '/../../resources/views/systems');
        $this->assertDirectoryDoesNotExist(__DIR__ . '/../../resources/views/users/systems');
    }

    public function test_data_migration_consolidates_permissions_before_dropping_systems(): void
    {
        $migration = file_get_contents(
            __DIR__ . '/../../database/migrations/2026_09_09_180000_remove_systems_structure.php'
        );

        $this->assertStringContainsString('mergeProfiles($profiles)', $migration);
        $this->assertStringContainsString('mergePermissions($permissions, $profileMap)', $migration);
        $this->assertStringContainsString("Schema::drop('systems')", $migration);
        $this->assertStringNotContainsString("'id_system' =>", $migration);
    }
}
