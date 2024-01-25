<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCashHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_cash_history', function (Blueprint $table) {
            $table->increments('id_user_cash_history');
            $table->unsignedInteger('id_transaction')->nullable();
            $table->unsignedInteger('id_authorization')->nullable();
            $table->unsignedInteger('id_batch')->nullable();
            $table->unsignedInteger('id_user');
            $table->date('date');
            $table->decimal('amount', 8, 2);
            $table->decimal('previous_balance', 8, 2);
            $table->decimal('current_balance', 8, 2);

            $table->foreign('id_transaction')->references('id_transaction')->on('transactions');
            $table->foreign('id_authorization')->references('id_authorization')->on('authorizations');
            $table->foreign('id_batch')->references('id_batch')->on('batches');
            $table->foreign('id_user')->references('id_user')->on('users');

            $table->unique(['id_authorization', 'id_user']);
            $table->unique(['id_batch', 'id_user']);

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
        Schema::dropIfExists('users_cash_history');
    }
}
