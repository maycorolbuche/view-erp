<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryType;

class CategoryTypeSeeder extends Seeder
{
    public function run()
    {
        CategoryType::updateOrCreate(
            ['slug' => 'expense'],
            ['name' => 'Despesa']
        );
    }
}
