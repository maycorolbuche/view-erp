<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Illuminate\Database\QueryException;
use App\Models\Category;
use App\Models\CategoryType;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();

        for ($i = 1; $i <= 10; $i++) {
            try {
                Category::create([
                    'id_category_type' => CategoryType::all()->random()['id_category_type'],
                    'name' => $faker->word,
                    'short_name' => $faker->word,
                ]);
            } catch (QueryException $e) {
                continue;
            }
        }
    }
}
