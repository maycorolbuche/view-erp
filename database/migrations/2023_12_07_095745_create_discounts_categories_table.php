<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts_categories', function (Blueprint $table) {
            $table->increments('id_discount_category');
            $table->unsignedInteger('id_discount');
            $table->unsignedInteger('id_category');

            $table->foreign('id_discount')->references('id_discount')->on('discounts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_category')->references('id_category')->on('categories')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_discount', 'id_category']);

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id_user')->on('users');
            $table->foreign('updated_by')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts_categories');
    }
}
