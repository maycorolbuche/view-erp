<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SecurityHardeningTest extends TestCase
{
    public function test_dangerous_public_maintenance_endpoints_are_not_registered(): void
    {
        $routes = file_get_contents(__DIR__ . '/../../routes/web.php');

        $this->assertStringNotContainsString("Route::get('/install'", $routes);
        $this->assertStringNotContainsString("Route::get('/test-mail'", $routes);
        $this->assertStringNotContainsString("Route::get('/cron/run'", $routes);
        $this->assertStringNotContainsString("Route::get('/cron/list'", $routes);
        $this->assertFileDoesNotExist(__DIR__ . '/../../app/Http/Controllers/Data/InstallController.php');
    }

    public function test_schedule_endpoint_is_preserved_for_server_cron(): void
    {
        $routes = file_get_contents(__DIR__ . '/../../routes/web.php');

        $this->assertStringContainsString("Route::get('/schedule'", $routes);
    }

    public function test_logout_uses_a_csrf_protected_post_route(): void
    {
        $routes = file_get_contents(__DIR__ . '/../../routes/web.php');

        $this->assertStringContainsString("Route::post('/logout'", $routes);
        $this->assertStringNotContainsString("Route::get('/logout'", $routes);
    }

    public function test_local_environment_does_not_bypass_password_authentication(): void
    {
        $request = file_get_contents(__DIR__ . '/../../app/Http/Requests/LoginRequest.php');
        $controller = file_get_contents(__DIR__ . '/../../app/Http/Controllers/Auth/LoginController.php');

        $this->assertStringNotContainsString("environment('local')", $request);
        $this->assertStringNotContainsString("environment('local')", $controller);
        $this->assertStringContainsString("'password' => 'required'", $request);
        $this->assertStringContainsString('Auth::attempt($credentials, $remember)', $controller);
    }

    public function test_datatable_routes_do_not_bypass_access_control(): void
    {
        $middleware = file_get_contents(__DIR__ . '/../../app/Http/Middleware/Access.php');

        $this->assertStringNotContainsString('$res == "datatable"', $middleware);
    }

    public function test_phpinfo_entrypoint_is_not_publicly_available(): void
    {
        $this->assertFileDoesNotExist(__DIR__ . '/../../public/version.php');
    }

    public function test_root_user_does_not_have_a_hard_coded_password(): void
    {
        $seeder = file_get_contents(__DIR__ . '/../../database/seeders/RootUserSeeder.php');

        $this->assertStringNotContainsString("'password' => '1234'", $seeder);
        $this->assertStringContainsString("config('app.root_user.password')", $seeder);
    }
}
