<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RelationshipDegree;
use App\Helpers\ConfigHelper;

class RelationshipDegreeSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.relationships_degrees') <> 'true') {
            RelationshipDegree::firstOrCreate(['name' => 'Pai/Mãe']);
            RelationshipDegree::firstOrCreate(['name' => 'Filho(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Cônjuje']);
            RelationshipDegree::firstOrCreate(['name' => 'Responsável Legal']);
            RelationshipDegree::firstOrCreate(['name' => 'Irmão(ã)']);
            RelationshipDegree::firstOrCreate(['name' => 'Avô(ó)']);
            RelationshipDegree::firstOrCreate(['name' => 'Tio(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Primo(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Sobrinho(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Neto(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Enteado(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Companheiro(a)']);
            RelationshipDegree::firstOrCreate(['name' => 'Padrasto/Madrasta']);
            RelationshipDegree::firstOrCreate(['name' => 'Outro']);

            ConfigHelper::set('seed.relationships_degrees', 'true');
        }
    }
}
