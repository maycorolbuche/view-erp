<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches_discounts', function (Blueprint $table) {
            $table->increments('id_batch_discount');
            $table->unsignedInteger('id_batch');
            $table->unsignedInteger('id_expense');
            $table->unsignedInteger('id_discount');
            $table->decimal('expense_amount', 8, 2);
            $table->decimal('expense_amount_prev', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->decimal('expense_amount_cur', 8, 2);
            $table->decimal('ref_amount', 8, 2);
            $table->date('ref_date');
            $table->integer('sequence');

            $table->foreign('id_batch')->references('id_batch')->on('batches')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_expense')->references('id_expense')->on('expenses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_discount')->references('id_discount')->on('discounts')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_batch', 'id_expense', 'id_discount']);

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
        Schema::dropIfExists('batches_discounts');
    }
}
