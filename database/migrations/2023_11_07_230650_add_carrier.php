<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Carrier;

class AddCarrier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Carrier::create([
            'name' => 'Vivo'
        ]);
        Carrier::create([
            'name' => 'TIM'
        ]);
        Carrier::create([
            'name' => 'Claro'
        ]);
        Carrier::create([
            'name' => 'Oi'
        ]);
        Carrier::create([
            'name' => 'Nextel'
        ]);
        Carrier::create([
            'name' => 'Sercomtel'
        ]);
        Carrier::create([
            'name' => 'Algar'
        ]);
        Carrier::create([
            'name' => "MVNOs"
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
            Carrier::truncate();
        } catch (Exception $e) {
        }
    }
}
