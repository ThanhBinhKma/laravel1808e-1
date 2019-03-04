<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
        	'name' => 'Quan ao di bien',
        	'parent_id' => 3,
        	'status' => 1,
        	'created_at' => date('Y-m-d'),
        	'updated_at' => null
        ]);
    }
}
