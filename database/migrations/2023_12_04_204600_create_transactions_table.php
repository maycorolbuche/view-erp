<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id_transaction');
            $table->unsignedInteger('id_authorization')->nullable();
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_batch')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('description');
            $table->string('type');

            $table->foreign('id_authorization')->references('id_authorization')->on('authorizations');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_batch')->references('id_batch')->on('batches');

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
        Schema::dropIfExists('transactions');
    }
}
