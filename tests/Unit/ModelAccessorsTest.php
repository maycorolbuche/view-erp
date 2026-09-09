<?php

namespace Tests\Unit;

use App\Models\Authorization;
use App\Models\Batch;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ModelAccessorsTest extends TestCase
{
    public function test_user_name_accessors_and_initials(): void
    {
        $user = new User(['name' => 'Mayco da Silva Rolbuche']);

        $this->assertSame('Mayco Rolbuche', $user->short_name);
        $this->assertSame('MR', $user->initials);
    }

    public function test_user_password_is_always_hashed(): void
    {
        $user = new User(['password' => 'secret-password']);

        $this->assertNotSame('secret-password', $user->password);
        $this->assertTrue(Hash::check('secret-password', $user->password));
    }

    /**
     * @dataProvider batchStatusProvider
     */
    public function test_batch_status_accessor(array $attributes, array $expected): void
    {
        $batch = new Batch($attributes);

        $this->assertSame($expected, $batch->status);
    }

    public static function batchStatusProvider(): array
    {
        return [
            'rejected' => [
                ['revised_status' => 'pending', 'revised_by' => 10],
                ['type' => 'rejected', 'color' => 'danger', 'label' => 'Rejeitado'],
            ],
            'pending' => [
                ['revised_status' => 'pending'],
                ['type' => 'pending', 'color' => 'warning', 'label' => 'Pendente'],
            ],
            'analyzing' => [
                ['revised_status' => 'analyzing'],
                ['type' => 'analyzing', 'color' => 'info', 'label' => 'Em Revisão'],
            ],
            'approved' => [
                ['revised_status' => 'approved', 'active' => true],
                ['type' => 'reviewed', 'color' => 'info', 'label' => 'Aprovado'],
            ],
            'closed' => [
                ['revised_status' => 'approved', 'active' => false],
                ['type' => 'closed', 'color' => 'success', 'label' => 'Concluído'],
            ],
        ];
    }

    public function test_authorization_date_accessors(): void
    {
        $authorization = new Authorization([
            'start_datetime' => '2026-09-09 08:30:00',
            'end_datetime' => '2026-09-10 17:45:00',
        ]);

        $this->assertSame('2026-09-09', $authorization->start_date);
        $this->assertSame('09/09/2026 08:30:00', $authorization->start_datetime_br);
        $this->assertSame('10/09/2026', $authorization->end_date_br);
    }

    public function test_fixed_and_repeating_holiday_types(): void
    {
        $fixed = new Holiday(['year' => 2026, 'month' => '09', 'day' => '07']);
        $repeating = new Holiday(['month' => '12', 'day' => '25']);
        $easter = new Holiday(['easter' => 0]);

        $this->assertSame('2026-09-07', $fixed->date);
        $this->assertSame('unique', $fixed->type);
        $this->assertSame('repeat', $repeating->type);
        $this->assertSame('easter', $easter->type);
    }
}
