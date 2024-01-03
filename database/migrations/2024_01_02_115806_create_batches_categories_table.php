<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches_categories', function (Blueprint $table) {
            $table->increments('id_batch_category');
            $table->unsignedInteger('id_batch');
            $table->unsignedInteger('id_category');
            $table->decimal('amount', 8, 2);
            $table->integer('expenses_count')->default(0);

            $table->foreign('id_batch')->references('id_batch')->on('batches')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_category')->references('id_category')->on('categories')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_batch', 'id_category']);

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
        Schema::dropIfExists('batches_categories');
    }
}
