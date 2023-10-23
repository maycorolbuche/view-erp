<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Route;

class AddRoute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Route::create([
            'id_route_group' => 1,
            'label' => 'Sistemas',
            'name' => 'systems',
            'uri' => 'systems',
            'controller' => 'SystemController',
            'resources' => ["index", "create", "store", "show", "edit", "update", "destroy"],
            'permissions' => ["store", "update", "destroy"],
            'icon' => 'glyphicons glyphicons-show_big_thumbnails',
            'sequence' => 10,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Route::truncate();
    }
}
