<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\EmploymentType;

class AddEmploymentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EmploymentType::create([
            'id_employment_type' => 1,
            'description' => 'CLT',
        ]);
        EmploymentType::create([
            'id_employment_type' => 2,
            'description' => 'PJ',
        ]);
        EmploymentType::create([
            'id_employment_type' => 3,
            'description' => 'Sócio',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EmploymentType::where('id_employment_type', 1)->delete();
        EmploymentType::where('id_employment_type', 2)->delete();
        EmploymentType::where('id_employment_type', 3)->delete();
    }
}
