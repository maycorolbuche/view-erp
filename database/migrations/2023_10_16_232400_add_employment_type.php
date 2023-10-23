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
            'description' => 'CLT',
        ]);
        EmploymentType::create([
            'description' => 'PJ',
        ]);
        EmploymentType::create([
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
        EmploymentType::truncate();
    }
}
