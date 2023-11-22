<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAuthorizationsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_authorizations_types', function (Blueprint $table) {
            $table->increments('id_user_authorization_type');
            $table->unsignedInteger('id_user_team');
            $table->unsignedInteger('id_user_parent');
            $table->unsignedInteger('id_user_child');
            $table->unsignedInteger('id_authorization_type');

            $table->foreign('id_user_team')->references('id_user_team')->on('users_teams')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user_parent')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user_child')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_authorization_type')->references('id_authorization_type')->on('authorizations_types')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_user_parent', 'id_user_child', 'id_authorization_type'], 'unique_user_authorization');

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
        Schema::dropIfExists('users_authorizations_types');
    }
}
