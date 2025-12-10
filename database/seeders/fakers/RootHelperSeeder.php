<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use App\Helpers\RootHelper as Root;

class RootHelperSeeder extends Seeder
{
    public function run()
    {
        Root::run();
    }
}
