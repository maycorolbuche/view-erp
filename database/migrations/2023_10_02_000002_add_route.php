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
            'resources' => ["index",  "store", "show", "update", "destroy", "datatable"],
            'permissions' => ["store", "update", "destroy"],
            'icon' => 'glyphicons glyphicons-show_big_thumbnails',
            'sequence' => 10,
            'root' => 1,
        ]);
        Route::create([
            'id_route_group' => 1,
            'id_route_parent' => 1,
            'label' => 'Menus Sistemas',
            'name' => 'systems.permissions',
            'uri' => 'systems/permissions',
            'controller' => 'SystemPermissionController',
            'resources' => ["index",  "show", "update"],
            'permissions' => ["update"],
            'icon' => 'glyphicon glyphicon-th-list',
            'sequence' => 20,
            'root' => 1,
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
