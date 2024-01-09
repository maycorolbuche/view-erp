<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Notification;

class AddNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Notification::create([
            'slug' => 'batch',
            'name' => 'Geração de Lote',
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
            Notification::truncate();
        } catch (Exception $e) {
        }
    }
}
