<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\RouteGroup;

class AddRoutesGroups extends Migration
{
    private static $sequenceValue = 0;

    public function sequence()
    {
        return ++self::$sequenceValue;
    }

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
            'sequence' => self::sequence(),
        ]);
        RouteGroup::create([
            'id_route_group' => 2,
            'icon' => 'glyphicons glyphicons-cogwheel',
            'label' => 'Parametrização',
            'sequence' => self::sequence(),
        ]);
        RouteGroup::create([
            'id_route_group' => 3,
            'icon' => 'fas fa-users-cog',
            'label' => 'Usuários e Acessos',
            'sequence' => self::sequence(),
        ]);
        RouteGroup::create([
            'id_route_group' => 4,
            'icon' => 'fas fa-user-friends',
            'label' => 'Pessoas',
            'sequence' => self::sequence(),
        ]);
        RouteGroup::create([
            'id_route_group' => 5,
            'icon' => 'far fa-money-bill-alt',
            'label' => 'Despesas',
            'sequence' => self::sequence(),
        ]);
        RouteGroup::create([
            'id_route_group' => 7,
            'icon' => 'fas fa-money',
            'label' => 'Financeiro',
            'sequence' => self::sequence(),
            'note' => 'As telas do financeiro mostram todos os usuários',
        ]);
        RouteGroup::create([
            'id_route_group' => 6,
            'icon' => 'fas fa-search',
            'label' => 'Consultas',
            'sequence' => self::sequence(),
            'note' => 'As consultas mostram dados de todos os usuários',
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
