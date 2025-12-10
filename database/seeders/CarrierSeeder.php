<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrier;
use App\Helpers\ConfigHelper;

class CarrierSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.carriers') <> 'true') {
            Carrier::firstOrCreate(['name' => 'Vivo']);
            Carrier::firstOrCreate(['name' => 'TIM']);
            Carrier::firstOrCreate(['name' => 'Claro']);
            Carrier::firstOrCreate(['name' => 'Oi']);
            Carrier::firstOrCreate(['name' => 'Nextel']);
            Carrier::firstOrCreate(['name' => 'Sercomtel']);
            Carrier::firstOrCreate(['name' => 'Algar']);
            Carrier::firstOrCreate(['name' => "MVNOs"]);

            ConfigHelper::set('seed.carriers', 'true');
        }
    }
}
