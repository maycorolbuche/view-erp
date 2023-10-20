<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\Root;

class RootHelperSeeder extends Seeder
{
    public function run()
    {
        Root::run();
    }
}
