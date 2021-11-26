<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses=["Just created","Accepted by vendor","Arrive Confirm","Start Charging","Charging Complete"];
        foreach ( $statuses as $key => $status) {
            DB::table('statuses')->insert([
                'name' => $status,
                'alias' =>  str_replace(" ","_",strtolower($status)),
            ]);
        }
    }
}
