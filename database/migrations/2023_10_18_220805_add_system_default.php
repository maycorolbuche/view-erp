<?php

use Illuminate\Database\Migrations\Migration;

class AddSystemDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('systems')->insert([
            'id_system' => 1,
            'slug' => 'root',
            'name' => 'Admin',
            'icon' => 'glyphicons glyphicons-cogwheels',
            'root' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
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
