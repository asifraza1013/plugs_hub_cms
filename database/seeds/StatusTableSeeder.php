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
        $statuses=config('constants.all_statuses');
        foreach ( $statuses as $key => $status) {
            DB::table('statuses')->insert([
                'name' => $status,
                'alias' =>  str_replace(" ","_",strtolower($status)),
            ]);
        }
    }
}
