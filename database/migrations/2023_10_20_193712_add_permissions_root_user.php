<?php

use Illuminate\Database\Migrations\Migration;
use App\Helpers\RootHelper as Root;

class AddPermissionsRootUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Root::run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
