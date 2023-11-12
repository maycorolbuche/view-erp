<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_dependents', function (Blueprint $table) {
            $table->increments('id_user_dependent');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_relationship_degree')->nullable();
            $table->string('name');
            $table->date('birth_date')->nullable();

            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_relationship_degree')->references('id_relationship_degree')->on('relationships_degrees')->onUpdate('set null')->onDelete('set null');

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
        Schema::dropIfExists('users_dependents');
    }
}
