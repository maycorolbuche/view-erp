<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('id_employment_type')->after('type_user')->nullable();
            $table->unsignedInteger('id_civil_status')->after('birth_date')->nullable();
            $table->unsignedInteger('id_branch')->after('state')->nullable();

            $table->foreign('id_employment_type')->references('id_employment_type')->on('employment_types');
            $table->foreign('id_civil_status')->references('id_civil_status')->on('civil_statuses');
            $table->foreign('id_branch')->references('id_branch')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_employment_type']);
            $table->dropForeign(['id_civil_status']);
            $table->dropForeign(['id_branch']);

            $table->dropColumn('id_employment_type');
            $table->dropColumn('id_civil_status');
            $table->dropColumn('id_branch');
        });
    }
}
