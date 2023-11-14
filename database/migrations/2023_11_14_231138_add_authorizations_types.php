<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\AuthorizationType;

class AddAuthorizationsTypes extends Migration
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
        AuthorizationType::create([
            'name' => 'Despesas',
            'approval' => 'one',
            'sequence' => self::sequence(),
        ]);
        AuthorizationType::create([
            'name' => 'Hora Extra',
            'approval' => 'one',
            'sequence' => self::sequence(),
        ]);
        AuthorizationType::create([
            'name' => 'Adiantamento',
            'approval' => 'one',
            'sequence' => self::sequence(),
        ]);
        AuthorizationType::create([
            'name' => 'Devolução Adiantamento',
            'approval' => 'one',
            'sequence' => self::sequence(),
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
            AuthorizationType::truncate();
        } catch (Exception $e) {
        }
    }
}
