<?php

namespace Tests\Unit;

use App\Http\Requests\LoginRequest;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    public function test_username_and_password_are_required(): void
    {
        $validator = validator([], (new LoginRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('username', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }

    public function test_credentials_use_email_when_login_is_an_email(): void
    {
        $request = LoginRequest::create('/login', 'POST', [
            'username' => 'user@example.com',
            'password' => 'secret',
        ]);
        $request->setContainer($this->app);

        $this->assertSame([
            'email' => 'user@example.com',
            'password' => 'secret',
        ], $request->getCredentials());
    }

    public function test_credentials_use_username_for_non_email_login(): void
    {
        $request = LoginRequest::create('/login', 'POST', [
            'username' => 'mayco',
            'password' => 'secret',
        ]);
        $request->setContainer($this->app);

        $this->assertSame([
            'username' => 'mayco',
            'password' => 'secret',
        ], $request->getCredentials());
    }
}
