<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
