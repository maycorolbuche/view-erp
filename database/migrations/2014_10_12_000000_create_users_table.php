<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->boolean('active')->default(true);
            $table->dateTime('last_access')->nullable();
            $table->integer('count_access')->nullable();
            $table->boolean('root')->default(0);
            $table->string('cpf_or_cnpj', 20)->nullable()->unique();
            $table->string('id_card', 20)->nullable()->unique();
            $table->string('pis', 20)->nullable()->unique();
            $table->date('birth_date', 20)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('address')->nullable();
            $table->string('number', 10)->nullable();
            $table->string('complement')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->date('hire_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->text('admission_notes')->nullable();

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
        Schema::dropIfExists('users');
    }
}
