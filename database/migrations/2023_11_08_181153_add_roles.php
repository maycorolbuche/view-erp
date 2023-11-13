<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Role;

class AddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Programador Jr.'
        ]);
        Role::create([
            'name' => 'Programador Pleno'
        ]);
        Role::create([
            'name' => 'Programador Sênior'
        ]);
        Role::create([
            'name' => 'Analista de Sistemas Jr.'
        ]);
        Role::create([
            'name' => 'Analista de Sistemas Pleno'
        ]);
        Role::create([
            'name' => 'Analista de Sistemas Sênior'
        ]);
        Role::create([
            'name' => 'Administrador de Banco de Dados'
        ]);
        Role::create([
            'name' => 'Gerente'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Role::truncate();
        } catch (Exception $e) {
        }
    }
}
