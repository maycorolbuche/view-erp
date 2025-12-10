<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CivilStatus;
use App\Helpers\ConfigHelper;

class CivilStatusSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.civil_statuses') <> 'true') {
            CivilStatus::firstOrCreate(['description' => 'Solteiro',]);
            CivilStatus::firstOrCreate(['description' => 'Casado',]);
            CivilStatus::firstOrCreate(['description' => 'Separado',]);
            CivilStatus::firstOrCreate(['description' => 'Divorciado',]);
            CivilStatus::firstOrCreate(['description' => 'Viúvo',]);

            ConfigHelper::set('seed.civil_statuses', 'true');
        }
    }
}
