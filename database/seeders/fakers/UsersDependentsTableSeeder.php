<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\UserDependent;
use App\Models\User;
use App\Models\RelationshipDegree;

class UsersDependentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 60; $i++) {
            try {
                UserDependent::create([
                    'id_user' => User::all()->random()['id_user'],
                    'id_relationship_degree' => RelationshipDegree::all()->random()['id_relationship_degree'],
                    'name' => $faker->name,
                    'birth_date' => $faker->date,
                ]);
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
