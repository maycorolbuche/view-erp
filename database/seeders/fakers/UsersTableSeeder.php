<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\EmploymentType;
use App\Models\CivilStatus;
use App\Models\Branch;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; $i++) {
            try {
                User::create([
                    'name' => $faker->name,
                    'username' => $faker->userName,
                    'email' => $faker->unique()->safeEmail,
                    'password' => '1234',
                    'active' => $faker->boolean,
                    'last_access' => $faker->dateTime,
                    'count_access' => $faker->numberBetween(1, 100),
                    'id_employment_type' => EmploymentType::all()->random()['id_employment_type'],
                    'cpf_or_cnpj' => $faker->unique()->numerify('###.###.###-##'),
                    'id_card' => $faker->unique()->numerify('##.###.###-##'),
                    'pis' => $faker->unique()->numerify('##########'),
                    'birth_date' => $faker->date,
                    'id_civil_status' => CivilStatus::all()->random()['id_civil_status'],
                    'zip_code' => $faker->postcode,
                    'address' => $faker->streetAddress,
                    'number' => $faker->buildingNumber,
                    'complement' => $faker->optional()->sentence,
                    'district' => $faker->word,
                    'city' => $faker->city,
                    'state' => $faker->stateAbbr,
                    'id_branch' => Branch::all()->random()['id_branch'],
                ]);
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
