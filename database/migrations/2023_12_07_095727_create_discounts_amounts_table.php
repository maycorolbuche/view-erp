<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts_amounts', function (Blueprint $table) {
            $table->increments('id_discount_amount');
            $table->unsignedInteger('id_discount');
            $table->date('date');
            $table->decimal('amount', 8, 2);

            $table->foreign('id_discount')->references('id_discount')->on('discounts')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_discount', 'date']);

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
        Schema::dropIfExists('discounts_amounts');
    }
}
