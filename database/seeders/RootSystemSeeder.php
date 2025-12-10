<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\System;

class RootSystemSeeder extends Seeder
{
    public function run()
    {
        if (!System::where('root', true)->exists()) {
            System::updateOrCreate(
                ['slug' => 'root',],
                [
                    'name' => 'Admin',
                    'icon' => 'glyphicons glyphicons-cogwheels',
                    'root' => true,
                ]
            );
        }
    }
}
