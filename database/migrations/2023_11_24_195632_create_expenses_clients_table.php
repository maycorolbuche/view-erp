<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses_clients', function (Blueprint $table) {
            $table->increments('id_expense_client');
            $table->unsignedInteger('id_expense');
            $table->unsignedInteger('id_client');
            $table->decimal('amount', 8, 2);
            $table->double('percentage');

            $table->foreign('id_expense')->references('id_expense')->on('expenses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_client')->references('id_client')->on('clients');

            $table->unique(['id_expense', 'id_client']);

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
        Schema::dropIfExists('expenses_clients');
    }
}
