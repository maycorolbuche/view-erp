<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Helpers\ConfigHelper;

class RoleSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.roles') <> 'true') {
            Role::firstOrCreate(['name' => 'Programador Jr.']);
            Role::firstOrCreate(['name' => 'Programador Pleno']);
            Role::firstOrCreate(['name' => 'Programador Sênior']);
            Role::firstOrCreate(['name' => 'Analista de Sistemas Jr.']);
            Role::firstOrCreate(['name' => 'Analista de Sistemas Pleno']);
            Role::firstOrCreate(['name' => 'Analista de Sistemas Sênior']);
            Role::firstOrCreate(['name' => 'Administrador de Banco de Dados']);
            Role::firstOrCreate(['name' => 'Gerente']);

            ConfigHelper::set('seed.roles', 'true');
        }
    }
}
