<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhoneType;
use App\Helpers\ConfigHelper;

class PhoneTypeSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.phones_types') <> 'true') {
            PhoneType::firstOrCreate(['description' => 'Celular']);
            PhoneType::firstOrCreate(['description' => 'Telefone Fixo']);
            PhoneType::firstOrCreate(['description' => 'Fax']);
            PhoneType::firstOrCreate(['description' => 'VoIP']);
            PhoneType::firstOrCreate(['description' => 'Telefone Virtual']);

            ConfigHelper::set('seed.phones_types', 'true');
        }
    }
}
