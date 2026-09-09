<?php

namespace Tests\Unit;

use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileRequest;
use Tests\TestCase;

class RequestValidationTest extends TestCase
{
    public function test_password_change_requires_current_password(): void
    {
        $validator = validator([
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ], (new PasswordChangeRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('current_password', $validator->errors()->toArray());
    }

    public function test_password_change_requires_confirmation(): void
    {
        $validator = validator([
            'current_password' => 'current-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'different-password',
        ], (new PasswordChangeRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('new_password', $validator->errors()->toArray());
    }

    public function test_valid_password_change_payload_passes(): void
    {
        $validator = validator([
            'current_password' => 'current-password',
            'new_password' => 'new-password',
            'new_password_confirmation' => 'new-password',
        ], (new PasswordChangeRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_profile_name_is_required(): void
    {
        $validator = validator([], (new ProfileRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }
}
