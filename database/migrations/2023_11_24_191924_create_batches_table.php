<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->increments('id_batch');
            $table->unsignedInteger('id_user');
            $table->boolean('active')->default(true);
            $table->boolean('automatic_batch')->default(false);
            $table->integer('expenses_count')->default(0);
            $table->decimal('amount', 8, 2)->default(0);
            $table->decimal('refundable_amount', 8, 2)->default(0);
            $table->decimal('non_refundable_amount', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('refund_amount', 8, 2)->default(0);
            $table->decimal('user_cash', 8, 2)->default(0);
            $table->decimal('extra_amount', 8, 2)->default(0);
            $table->string('reason_extra_amount')->nullable();
            $table->decimal('amount_paid', 8, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->unsignedInteger('revised_by')->nullable();
            $table->datetime('revised_at')->nullable();
            $table->enum('revised_status', ['pending', 'analyzing', 'approved'])->default('pending');
            $table->date('estimated_payment_date')->nullable();

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('revised_by')->references('id_user')->on('users');

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
        Schema::dropIfExists('batches');
    }
}
