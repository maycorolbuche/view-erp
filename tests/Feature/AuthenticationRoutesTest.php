<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticationRoutesTest extends TestCase
{
    public function test_guest_can_open_login_page(): void
    {
        $this->get('/login')->assertOk();
    }

    public function test_guest_is_redirected_from_protected_home_page(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_logout_is_not_available_through_get(): void
    {
        $this->get('/logout')->assertStatus(405);
    }

    public function test_guest_posting_logout_is_redirected_to_login(): void
    {
        $this->post('/logout')->assertRedirect('/login');
    }
}
