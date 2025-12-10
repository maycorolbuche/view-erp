<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\Branch;

class BranchesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 4; $i++) {
            try {
                Branch::create([
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
