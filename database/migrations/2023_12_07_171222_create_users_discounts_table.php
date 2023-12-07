<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_discounts', function (Blueprint $table) {
            $table->increments('id_user_discount');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_discount');

            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_discount')->references('id_discount')->on('discounts')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_user', 'id_discount']);

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
        Schema::dropIfExists('users_discounts');
    }
}
