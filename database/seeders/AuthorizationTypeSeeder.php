<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthorizationType;

class AuthorizationTypeSeeder extends Seeder
{
    private static $sequenceValue = 0;

    public function sequence()
    {
        return ++self::$sequenceValue;
    }

    public function run()
    {
        AuthorizationType::firstOrCreate(
            ['type' => 'expense'],
            [
                'name' => 'Despesas',
                'approval' => 'one',
                'sequence' => self::sequence(),
            ]
        );
        AuthorizationType::firstOrCreate(
            ['type' => 'cash-advance'],
            [
                'name' => 'Adiantamento',
                'approval' => 'one',
                'sequence' => self::sequence(),
            ]
        );
        AuthorizationType::firstOrCreate(
            ['type' => 'cash-advance-return'],
            [
                'name' => 'Devolução Adiantamento',
                'approval' => 'one',
                'sequence' => self::sequence(),
            ]
        );
    }
}
