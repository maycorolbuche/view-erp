<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LoginFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Never recreate tables on a persistent connection, even with cached config.
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));

        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('root')->default(false);
            // Authenticated triggers UpdateLastAccess and the audit trait.
            $table->dateTime('last_access')->nullable();
            $table->integer('count_access')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_active_user_can_log_in_with_username(): void
    {
        $user = $this->createUser();

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'secret-password',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertNotNull($user->last_access);
        $this->assertSame(1, (int) $user->count_access);
        $this->assertSame($user->id_user, (int) $user->updated_by);
    }

    public function test_user_can_log_in_with_email(): void
    {
        $user = $this->createUser();

        $this->post('/login', [
            'username' => $user->email,
            'password' => 'secret-password',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_password_does_not_authenticate_user(): void
    {
        $user = $this->createUser();

        $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'incorrect-password',
        ])->assertRedirect('/login')->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_inactive_user_is_logged_out_after_valid_credentials(): void
    {
        $user = $this->createUser(['active' => false]);

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'secret-password',
        ])->assertRedirect('/login')->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_user_without_password_is_sent_to_password_reset(): void
    {
        $user = $this->createUser();
        $user->setRawAttributes(array_merge($user->getAttributes(), ['password' => null]));
        $user->save();

        $this->post('/login', [
            'username' => $user->username,
            'password' => 'any-password',
        ])->assertRedirect('/password/reset')->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_logout_invalidates_authenticated_session(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->withSession(['private-value' => 'must-be-removed'])
            ->post('/logout')
            ->assertRedirect('login')
            ->assertSessionMissing('private-value');

        $this->assertGuest();
    }

    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Test User',
            'username' => 'test-user',
            'email' => 'test@example.com',
            'password' => 'secret-password',
            'active' => true,
        ], $attributes));
    }
}
