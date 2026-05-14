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
                'icon' => 'bi bi-grid',
                'label' => 'Sistemas',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 2],
            [
                'icon' => 'bi bi-gear',
                'label' => 'Parametrização',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 3],
            [
                'icon' => 'bi bi-file-person',
                'label' => 'Usuários e Acessos',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 4],
            [
                'icon' => 'bi bi-people',
                'label' => 'Pessoas',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 5],
            [
                'icon' => 'bi bi-cash-coin',
                'label' => 'Despesas',
                'sequence' => self::sequence(),
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 7],
            [
                'icon' => 'bi bi-currency-dollar',
                'label' => 'Financeiro',
                'sequence' => self::sequence(),
                'note' => 'As telas do financeiro mostram dados de todos os usuários',
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 6],
            [
                'icon' => 'bi bi-search',
                'label' => 'Consultas',
                'sequence' => self::sequence(),
                'note' => 'As consultas mostram dados de todos os usuários',
            ]
        );
        RouteGroup::updateOrCreate(
            ['id_route_group' => 8],
            [
                'icon' => 'bi bi-file-bar-graph',
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
                'icon' => 'bi bi-file-earmark',
                'label' => 'Logs',
                'sequence' => self::sequence(),
                'note' => 'Os logs mostram dados de todos os usuários',
            ]
        );
    }
}
