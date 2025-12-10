<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        Notification::updateOrCreate(
            ['slug' => 'batch_review'],
            ['name' => 'Revisão de Lotes', 'id_route' => 53]
        );
    }
}
