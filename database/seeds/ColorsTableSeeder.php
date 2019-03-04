<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
        	'name_color' => 'Pink',
        	'status' => 1,
        	'description' => 'Mau hong mong mo',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null
        ]);
    }
}
