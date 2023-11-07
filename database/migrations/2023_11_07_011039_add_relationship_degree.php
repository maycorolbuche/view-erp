<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\RelationshipDegree;

class AddRelationshipDegree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RelationshipDegree::create([
            'name' => 'Pai/Mãe',
        ]);
        RelationshipDegree::create([
            'name' => 'Filho(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Cônjuje',
        ]);
        RelationshipDegree::create([
            'name' => 'Responsável Legal',
        ]);
        RelationshipDegree::create([
            'name' => 'Irmão(ã)',
        ]);
        RelationshipDegree::create([
            'name' => 'Avô(ó)',
        ]);
        RelationshipDegree::create([
            'name' => 'Tio(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Primo(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Sobrinho(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Neto(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Enteado(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Companheiro(a)',
        ]);
        RelationshipDegree::create([
            'name' => 'Padrasto/Madrasta',
        ]);
        RelationshipDegree::create([
            'name' => 'Outro',
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
            RelationshipDegree::truncate();
        } catch (Exception $e) {
        }
    }
}
