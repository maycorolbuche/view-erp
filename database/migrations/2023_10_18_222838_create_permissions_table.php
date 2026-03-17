<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id_permission');
            $table->unsignedInteger('id_system');
            $table->unsignedInteger('id_route');
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('id_profile')->nullable();
            $table->text('permissions'); //$table->json('permissions');

            $table->foreign('id_system')->references('id_system')->on('systems')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_route')->references('id_route')->on('routes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_profile')->references('id_profile')->on('profiles')->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['id_route', 'id_system', 'id_user']);
            $table->unique(['id_route', 'id_system', 'id_profile']);

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
        Schema::dropIfExists('permissions');
    }
}
