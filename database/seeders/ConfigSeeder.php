<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        Config::firstOrCreate(
            ['key' => 'authorizations.active.days_to_close'],
            ['value' => '30']
        );

        Config::firstOrCreate(
            ['key' => 'batches.active.days_to_close_without_refund'],
            ['value' => '30']
        );

        Config::firstOrCreate(
            ['key' => 'batches.standard_payment_days'],
            ['value' => '3']
        );
    }
}
