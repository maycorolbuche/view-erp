<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RootUserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('root', true)->exists()) {
            User::updateOrCreate(
                ['username' => 'admin'],
                [
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => '1234',
                    'root' => true,
                ]
            );
        }
    }
}
