<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id_expense');
            $table->unsignedInteger('id_authorization');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_batch')->nullable();
            $table->date('date');
            $table->unsignedInteger('id_category');
            $table->unsignedInteger('id_payment_method');
            $table->decimal('amount', 8, 2);
            $table->text('notes')->nullable();

            $table->foreign('id_authorization')->references('id_authorization')->on('authorizations');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_batch')->references('id_batch')->on('batches');
            $table->foreign('id_category')->references('id_category')->on('categories');
            $table->foreign('id_payment_method')->references('id_payment_method')->on('payment_methods');

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
        Schema::dropIfExists('expenses');
    }
}
