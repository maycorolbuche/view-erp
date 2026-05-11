<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RouteGroup;

class RouteGroupSeeder extends Seeder
{
    private static $sequenceValue = 0;

    public function sequence()
    {
        return ++self::$sequenceValue;
    }

    public function run()
    {
        RouteGroup::updateOrCreate(
            ['id_route_group' => 1],
            [
                'icon' => 'glyphicons glyphicons-show_thumbnails_with_lines',
                'label' => 'Sistemas',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 2],
            [
                'icon' => 'glyphicons glyphicons-cogwheel',
                'label' => 'Parametrização',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 3],
            [
                'icon' => 'fas fa-users-cog',
                'label' => 'Usuários e Acessos',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 4],
            [
                'icon' => 'fas fa-user-friends',
                'label' => 'Pessoas',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 5],
            [
                'icon' => 'far fa-money-bill-alt',
                'label' => 'Despesas',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 7],
            [
                'icon' => 'fas fa-money',
                'label' => 'Financeiro',
                'sequence' => self::sequence(),
                'note' => 'As telas do financeiro mostram dados de todos os usuários',
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 6],
            [
                'icon' => 'fas fa-search',
                'label' => 'Consultas',
                'sequence' => self::sequence(),
                'note' => 'As consultas mostram dados de todos os usuários',
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 8],
            [
                'icon' => 'fas fa-file-contract',
                'label' => 'Relatórios',
                'sequence' => self::sequence(),
                'note' => 'Os relatórios mostram dados de todos os usuários',
            ]
        );
        /*RouteGroup::updateOrCreate(
            ['id_route_group' => 10],
            [
                'icon' => 'fas fa-lock',
                'label' => 'Segurança',
                'sequence' => self::sequence(),
                'note' => 'Configurações de segurança de todo o sistema',
            ]
        );*/
        RouteGroup::updateOrCreate(
            ['id_route_group' => 9],
            [
                'icon' => 'far fa-file-alt',
                'label' => 'Logs',
                'sequence' => self::sequence(),
                'note' => 'Os logs mostram dados de todos os usuários',
            ]
        );
    }
}
