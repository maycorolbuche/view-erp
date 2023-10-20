<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create(); // Crie uma instância do Faker

        foreach (range(1, 10) as $index) { // Criar 10 registros de usuário
            User::create([
                'name' => $faker->name,
                'username' => $faker->userName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Use a senha criptografada
                'active' => $faker->boolean,
                'last_access' => $faker->dateTime,
                'count_access' => $faker->numberBetween(1, 100),
                //'id_employment_type' => $faker->numberBetween(1, 5),
                'cpf_or_cnpj' => $faker->unique()->numerify('###.###.###-##'),
                'id_card' => $faker->unique()->numerify('##.###.###-##'),
                'pis' => $faker->unique()->numerify('##########'),
                'birth_date' => $faker->date,
                //'id_civil_status' => $faker->numberBetween(1, 4),
                'zip_code' => $faker->postcode,
                'address' => $faker->streetAddress,
                'number' => $faker->buildingNumber,
                'complement' => $faker->optional()->sentence,
                'district' => $faker->word,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                //'id_branch' => $faker->numberBetween(1, 3),
            ]);
        }
    }
}
