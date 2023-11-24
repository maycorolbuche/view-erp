<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\PaymentMethod;

class AddPaymentMethodsTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        PaymentMethod::create([
            'name' => 'Recursos Próprios',
            'refundable' => true,
        ]);
        PaymentMethod::create([
            'name' => 'Cartão Corporativo',
            'refundable' => false,
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
            PaymentMethod::truncate();
        } catch (Exception $e) {
        }
    }
}
