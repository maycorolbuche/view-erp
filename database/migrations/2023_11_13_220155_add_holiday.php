<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Holiday;

class AddHoliday extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Holiday::create([
            'month' => 1,
            'day' => 1,
            'name' => 'Confraternização Universal'
        ]);
        Holiday::create([
            'month' => 4,
            'day' => 21,
            'name' => 'Tiradentes'
        ]);
        Holiday::create([
            'month' => 5,
            'day' => 1,
            'name' => 'Dia do Trabalhador'
        ]);
        Holiday::create([
            'month' => 9,
            'day' => 7,
            'name' => 'Dia da Independência'
        ]);
        Holiday::create([
            'month' => 10,
            'day' => 12,
            'name' => 'N. S. Aparecida'
        ]);
        Holiday::create([
            'month' => 11,
            'day' => 2,
            'name' => 'Finados'
        ]);
        Holiday::create([
            'month' => 11,
            'day' => 15,
            'name' => 'Proclamação da República'
        ]);
        Holiday::create([
            'month' => 12,
            'day' => 25,
            'name' => 'Natal'
        ]);
        Holiday::create([
            'easter' => 0,
            'name' => 'Páscoa'
        ]);
        Holiday::create([
            'easter' => -47,
            'name' => 'Carnaval'
        ]);
        Holiday::create([
            'easter' => -2,
            'name' => 'Sexta-feira Santa'
        ]);
        Holiday::create([
            'easter' => 60,
            'name' => 'Corpus Christ'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Holiday::truncate();
        } catch (Exception $e) {
        }
    }
}
