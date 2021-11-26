<?php

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
        // $this->call(UserSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
    }
}
