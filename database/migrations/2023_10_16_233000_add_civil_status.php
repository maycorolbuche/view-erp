<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\CivilStatus;

class AddCivilStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CivilStatus::create([
            'description' => 'Solteiro',
        ]);
        CivilStatus::create([
            'description' => 'Casado',
        ]);
        CivilStatus::create([
            'description' => 'Separado',
        ]);
        CivilStatus::create([
            'description' => 'Divorciado',
        ]);
        CivilStatus::create([
            'description' => 'Viúvo',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CivilStatus::truncate();
    }
}
