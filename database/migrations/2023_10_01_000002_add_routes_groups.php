<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\RouteGroup;

class AddRoutesGroups extends Migration
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
            'icon' => 'glyphicons glyphicons-show_thumbnails_with_lines',
            'label' => 'Sistemas',
            'sequence' => 10,
        ]);
        RouteGroup::create([
            'id_route_group' => 2,
            'icon' => 'glyphicons glyphicons-cogwheel',
            'label' => 'Parametrização',
            'sequence' => 20,
        ]);
        RouteGroup::create([
            'id_route_group' => 3,
            'icon' => 'fas fa-users-cog',
            'label' => 'Usuários e Acessos',
            'sequence' => 30,
        ]);
        RouteGroup::create([
            'id_route_group' => 4,
            'icon' => 'fas fa-user-friends',
            'label' => 'Pessoas',
            'sequence' => 40,
        ]);
        RouteGroup::create([
            'id_route_group' => 5,
            'icon' => 'fas fa-money-bill',
            'label' => 'Despesas',
            'sequence' => 50,
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
