<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Config;

class AddConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Config::create([
            'key' => 'authorizations.active.days_to_close',
            'value' => '30',
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
            Config::truncate();
        } catch (Exception $e) {
        }
    }
}
