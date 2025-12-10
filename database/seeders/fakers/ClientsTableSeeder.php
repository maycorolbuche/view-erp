<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\Client;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; $i++) {
            try {
                Client::create([
                    'name' => $faker->city,
                    'short_name' => $faker->word,
                    'zip_code' => $faker->postcode,
                    'address' => $faker->streetAddress,
                    'number' => $faker->buildingNumber,
                    'complement' => $faker->optional()->sentence,
                    'district' => $faker->word,
                    'city' => $faker->city,
                    'state' => $faker->stateAbbr,
                ]);
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
