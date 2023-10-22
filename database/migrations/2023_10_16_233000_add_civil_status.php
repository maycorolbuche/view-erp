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
            'id_civil_status' => 1,
            'description' => 'Solteiro',
        ]);
        CivilStatus::create([
            'id_civil_status' => 2,
            'description' => 'Casado',
        ]);
        CivilStatus::create([
            'id_civil_status' => 3,
            'description' => 'Separado',
        ]);
        CivilStatus::create([
            'id_civil_status' => 4,
            'description' => 'Divorciado',
        ]);
        CivilStatus::create([
            'id_civil_status' => 5,
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
        CivilStatus::where('id_civil_status', 1)->delete();
        CivilStatus::where('id_civil_status', 2)->delete();
        CivilStatus::where('id_civil_status', 3)->delete();
        CivilStatus::where('id_civil_status', 4)->delete();
        CivilStatus::where('id_civil_status', 5)->delete();
    }
}
