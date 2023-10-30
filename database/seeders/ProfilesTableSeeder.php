<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\Profile;
use App\Models\EmploymentType;
use App\Models\System;
use App\Models\Branch;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; $i++) {
            try {
                Profile::create([
                    'name' => $faker->name,
                    'id_system' => System::all()->random()['id_system'],
                ]);
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
