<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authorizations', function (Blueprint $table) {
            $table->unsignedInteger('id_file')->nullable()->after('approved');
            $table->foreign('id_file')->references('id_file')->on('files');
        });
    }

    public function down(): void
    {
        Schema::table('authorizations', function (Blueprint $table) {
            $table->dropForeign(['id_file']);
            $table->dropColumn('id_file');
        });
    }
};
