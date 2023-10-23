<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\RouteGroup;

class AddRouteGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RouteGroup::create([
            'id_route_group' => 1,
            'icon' => 'glyphicons glyphicons-cogwheels',
            'label' => 'Parametrização',
            'sequence' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RouteGroup::truncate();
    }
}
