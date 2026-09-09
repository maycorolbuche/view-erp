<?php

namespace Tests\Unit;

use App\Http\Middleware\CheckUserActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function test_active_user_continues_to_next_middleware(): void
    {
        Auth::shouldReceive('user')->once()->andReturn((object) ['active' => true]);

        $response = (new CheckUserActive())->handle(
            Request::create('/'),
            fn () => new Response('continued', 200)
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('continued', $response->getContent());
    }

    public function test_inactive_user_is_logged_out_and_redirected(): void
    {
        Auth::shouldReceive('user')->once()->andReturn((object) ['active' => false]);
        Auth::shouldReceive('logout')->once();

        $response = (new CheckUserActive())->handle(
            Request::create('/'),
            fn () => new Response('continued', 200)
        );

        $this->assertSame(url('/login'), $response->getTargetUrl());
        $this->assertTrue(session('errors')->has('message'));
    }
}
