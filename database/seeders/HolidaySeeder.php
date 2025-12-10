<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Holiday;
use App\Helpers\ConfigHelper;

class HolidaySeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.holidays') <> 'true') {
            Holiday::firstOrCreate([
                'month' => 1,
                'day' => 1,
                'name' => 'Confraternização Universal'
            ]);
            Holiday::firstOrCreate([
                'month' => 4,
                'day' => 21,
                'name' => 'Tiradentes'
            ]);
            Holiday::firstOrCreate([
                'month' => 5,
                'day' => 1,
                'name' => 'Dia do Trabalhador'
            ]);
            Holiday::firstOrCreate([
                'month' => 9,
                'day' => 7,
                'name' => 'Dia da Independência'
            ]);
            Holiday::firstOrCreate([
                'month' => 10,
                'day' => 12,
                'name' => 'N. S. Aparecida'
            ]);
            Holiday::firstOrCreate([
                'month' => 11,
                'day' => 2,
                'name' => 'Finados'
            ]);
            Holiday::firstOrCreate([
                'month' => 11,
                'day' => 15,
                'name' => 'Proclamação da República'
            ]);
            Holiday::firstOrCreate([
                'month' => 12,
                'day' => 25,
                'name' => 'Natal'
            ]);
            Holiday::firstOrCreate([
                'easter' => 0,
                'name' => 'Páscoa'
            ]);
            Holiday::firstOrCreate([
                'easter' => -47,
                'name' => 'Carnaval'
            ]);
            Holiday::firstOrCreate([
                'easter' => -2,
                'name' => 'Sexta-feira Santa'
            ]);
            Holiday::firstOrCreate([
                'easter' => 60,
                'name' => 'Corpus Christi'
            ]);

            ConfigHelper::set('seed.holidays', 'true');
        }
    }
}
