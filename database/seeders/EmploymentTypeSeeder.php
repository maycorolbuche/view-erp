<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmploymentType;
use App\Helpers\ConfigHelper;

class EmploymentTypeSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.employment_types') <> 'true') {
            EmploymentType::firstOrCreate(['description' => 'CLT',]);
            EmploymentType::firstOrCreate(['description' => 'PJ',]);
            EmploymentType::firstOrCreate(['description' => 'Sócio',]);
            EmploymentType::firstOrCreate(['description' => 'Externo',]);

            ConfigHelper::set('seed.employment_types', 'true');
        }
    }
}
