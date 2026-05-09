<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories_users', function (Blueprint $table) {
            $table->id('id_category_user');
            $table->unsignedInteger('id_category');
            $table->unsignedInteger('id_user');

            $table->foreign('id_category')->references('id_category')->on('categories')->cascadeOnDelete();;
            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();;

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id_user')->on('users');
            $table->foreign('updated_by')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories_users');
    }
};
