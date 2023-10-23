<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id_route');
            $table->unsignedInteger('id_route_group');
            $table->unsignedInteger('id_route_parent')->nullable();
            $table->string('label');
            $table->string('name')->unique();
            $table->string('uri')->unique();
            $table->string('controller');
            $table->json('resources');
            $table->json('permissions');
            $table->string('icon')->nullable();
            $table->integer('sequence');
            $table->boolean('root')->default(0);

            $table->foreign('id_route_group')->references('id_route_group')->on('routes_groups');
            $table->foreign('id_route_parent')->references('id_route')->on('routes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
