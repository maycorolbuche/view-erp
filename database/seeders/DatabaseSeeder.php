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
        $this->call(ConfigSeeder::class);

        $this->call(RouteGroupSeeder::class);
        $this->call(RouteSeeder::class);

        $this->call(RootUserSeeder::class);
        $this->call(RootSystemSeeder::class);
        $this->call(RootPermissionSeeder::class);

        $this->call(NotificationSeeder::class);

        $this->call(EmploymentTypeSeeder::class);
        $this->call(CivilStatusSeeder::class);
        $this->call(RelationshipDegreeSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(CarrierSeeder::class);
        $this->call(PhoneTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(HolidaySeeder::class);
        $this->call(AuthorizationTypeSeeder::class);
        $this->call(CategoryTypeSeeder::class);
    }
}
