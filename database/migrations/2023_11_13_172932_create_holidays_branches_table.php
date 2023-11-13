<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays_branches', function (Blueprint $table) {
            $table->increments('id_holiday_branch');
            $table->unsignedInteger('id_holiday');
            $table->unsignedInteger('id_branch');

            $table->foreign('id_holiday')->references('id_holiday')->on('holidays')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_branch')->references('id_branch')->on('branches')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('holidays_branches');
    }
}
