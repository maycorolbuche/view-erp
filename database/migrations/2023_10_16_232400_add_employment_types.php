<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\EmploymentType;

class AddEmploymentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EmploymentType::create([
            'description' => 'CLT',
        ]);
        EmploymentType::create([
            'description' => 'PJ',
        ]);
        EmploymentType::create([
            'description' => 'Sócio',
        ]);
        EmploymentType::create([
            'description' => 'Externo',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        EmploymentType::truncate();
    }
}
