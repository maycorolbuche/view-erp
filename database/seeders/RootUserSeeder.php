<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class RootUserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('root', true)->exists()) {
            $password = config('app.root_user.password');
            $email = config('app.root_user.email');

            if (!$password || strlen($password) < 12) {
                throw new \RuntimeException('Defina ROOT_USER_PASSWORD com pelo menos 12 caracteres antes de executar os seeders.');
            }

            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Defina um ROOT_USER_EMAIL válido antes de executar os seeders.');
            }

            User::updateOrCreate(
                ['username' => config('app.root_user.username')],
                [
                    'name' => 'Admin',
                    'email' => $email,
                    'password' => $password,
                    'root' => true,
                ]
            );
        }
    }
}
