<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\System;

class AddSystemDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        System::create([
            'id_system' => 1,
            'slug' => 'root',
            'name' => 'Admin',
            'icon' => 'glyphicons glyphicons-cogwheels',
            'root' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('systems')->where('id_system', 1)->delete();
    }
}
