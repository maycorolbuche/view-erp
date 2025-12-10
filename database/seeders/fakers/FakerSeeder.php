<?php

namespace Database\Seeders\Fakers;

use Illuminate\Database\Seeder;
use Database\Seeders\Fakers\SystemsTableSeeder;
use Database\Seeders\Fakers\BranchesTableSeeder;
use Database\Seeders\Fakers\ClientsTableSeeder;
use Database\Seeders\Fakers\ProfilesTableSeeder;
use Database\Seeders\Fakers\UsersTableSeeder;
use Database\Seeders\Fakers\UsersDependentsTableSeeder;
use Database\Seeders\Fakers\UsersTeamsSeeder;
use Database\Seeders\Fakers\CategoriesTableSeeder;
use Database\Seeders\Fakers\AuthorizationsTableSeeder;
use Database\Seeders\Fakers\ExpensesTableSeeder;
use Database\Seeders\Fakers\PermissionsSeeder;
use Database\Seeders\Fakers\RootHelperSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemsTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UsersDependentsTableSeeder::class);
        $this->call(UsersTeamsSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AuthorizationsTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);

        $this->call(PermissionsSeeder::class);
        $this->call(RootHelperSeeder::class);
    }
}
