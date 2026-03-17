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
            $table->string('label');
            $table->string('name')->unique();
            $table->string('uri')->unique();
            $table->string('controller');
            $table->text('resources'); //$table->json('resources');
            $table->text('permissions'); //$table->json('permissions');
            $table->string('icon')->nullable();
            $table->integer('sequence');
            $table->boolean('root')->default(0);

            $table->foreign('id_route_group')->references('id_route_group')->on('routes_groups')->onUpdate('cascade')->onDelete('cascade');

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
