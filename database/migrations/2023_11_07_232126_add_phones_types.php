<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\PhoneType;

class AddPhonesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        PhoneType::create([
            'description' => 'Celular'
        ]);
        PhoneType::create([
            'description' => 'Telefone Fixo'
        ]);
        PhoneType::create([
            'description' => 'Fax'
        ]);
        PhoneType::create([
            'description' => 'VoIP'
        ]);
        PhoneType::create([
            'description' => 'Telefone Virtual'
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
            PhoneType::truncate();
        } catch (Exception $e) {
        }
    }
}
