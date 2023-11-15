<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizationsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations_clients', function (Blueprint $table) {
            $table->increments('id_authorization_client');
            $table->unsignedInteger('id_authorization');
            $table->unsignedInteger('id_client');

            $table->unique(['id_authorization', 'id_client']);

            $table->foreign('id_authorization')->references('id_authorization')->on('authorizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_client')->references('id_client')->on('clients')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('authorizations_clients');
    }
}
