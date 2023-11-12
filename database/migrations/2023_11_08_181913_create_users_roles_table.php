<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->increments('id_user_role');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_role');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_role')->references('id_role')->on('roles')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('users_roles');
    }
}
