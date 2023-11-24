<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\CategoryType;

class AddCategoriesTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CategoryType::create([
            'name' => 'Despesa',
            'slug' => 'expense',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            CategoryType::truncate();
        } catch (Exception $e) {
        }
    }
}
