<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use App\Helpers\ConfigHelper;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        if (ConfigHelper::get('seed.payment_methods') <> 'true') {
            PaymentMethod::updateOrCreate(
                ['name' => 'Recursos Próprios'],
                ['refundable' => true]
            );
            PaymentMethod::updateOrCreate(
                ['name' => 'Cartão Corporativo'],
                ['refundable' => false]
            );

            ConfigHelper::set('seed.payment_methods', 'true');
        }
    }
}
