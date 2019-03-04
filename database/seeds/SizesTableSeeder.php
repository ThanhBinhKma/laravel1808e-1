<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
        	'letter_size' => 'L',
        	'number_size' => null,
        	'status' => 1,
        	'description' => 'Size danh cho nguoi sieu chuan',
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null
        ]);
    }
}
