<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(
            [
            'id' => 1,
            ],
            [
                'admin_commission' => 5,
                'google_map_key' => 'map api key',
            ],
    );
    }
}
