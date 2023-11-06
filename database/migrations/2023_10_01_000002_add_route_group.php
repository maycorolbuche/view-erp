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
            'icon' => 'glyphicons glyphicons-cogwheel',
            'label' => 'Parametrização',
            'sequence' => 10,
        ]);
        RouteGroup::create([
            'id_route_group' => 2,
            'icon' => 'fas fa-users-cog',
            'label' => 'Usuários e Acessos',
            'sequence' => 20,
        ]);
        RouteGroup::create([
            'id_route_group' => 3,
            'icon' => 'fas fa-user-friends',
            'label' => 'Pessoas',
            'sequence' => 30,
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
