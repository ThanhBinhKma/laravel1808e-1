<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
        	'brand_name' => 'Owen',
        	'address' => 'Ha Noi',
        	'status' => 1,
        	'description' => 'lich lam - sang trong',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null
        ]);
    }
}
