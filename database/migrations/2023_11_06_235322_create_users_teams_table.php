<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_teams', function (Blueprint $table) {
            $table->increments('id_user_team');
            $table->unsignedInteger('id_user_parent');
            $table->unsignedInteger('id_user_child');
            $table->json('authorizations');

            $table->foreign('id_user_parent')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user_child')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_user_parent', 'id_user_child']);

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
        Schema::dropIfExists('users_teams');
    }
}
