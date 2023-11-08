<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_phones', function (Blueprint $table) {
            $table->increments('id_user_phone');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_carrier')->nullable();
            $table->unsignedInteger('id_phone_type')->nullable();
            $table->string('phone');
            $table->string('contact_name')->nullable();
            $table->boolean('is_business')->nullable();
            $table->boolean('has_whatsapp')->nullable();
            $table->text('notes')->nullable();

            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_carrier')->references('id_carrier')->on('carriers');
            $table->foreign('id_phone_type')->references('id_phone_type')->on('phones_types');

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
        Schema::dropIfExists('users_phones');
    }
}
