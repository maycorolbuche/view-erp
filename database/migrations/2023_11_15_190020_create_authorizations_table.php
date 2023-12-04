<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->increments('id_authorization');
            $table->unsignedInteger('id_authorization_parent')->nullable();
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_authorization_type');
            $table->string('description');
            $table->datetime('start_datetime');
            $table->datetime('end_datetime');
            $table->decimal('amount', 8, 2)->nullable();
            $table->boolean('self')->default(true);
            $table->boolean('active')->default(true);
            $table->boolean('approved')->nullable();

            $table->foreign('id_authorization_parent')->references('id_authorization')->on('authorizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_authorization_type')->references('id_authorization_type')->on('authorizations_types')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('authorizations');
    }
}
