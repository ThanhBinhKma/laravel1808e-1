<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$strIdCat = json_encode([1,3]);
    	// 1,3 : id cua bang categories
    	// json_encode : su dung chuoi json (object cua javascript)
    	// {key:value, key2:}
    	$strIdColor = json_encode([1,2]);
    	$strIdSize = json_encode([3,6]);
    	$strImage = json_encode(['jean-001.png','jean-002.png','jean-003.png']);

        DB::table('products')->insert([
        	'name_product' => 'Quan jean Korea SD003',
        	'categories_id' => $strIdCat,
        	'colors_id' => $strIdColor,
        	'sizes_id' => $strIdSize,
        	'brands_id' => 1,
        	'price' => 200000,
        	'qty' => 10,
        	'description' => 'Quan dep - thoi trang han quoc',
        	'image_product' => $strImage,
        	'sale_off' => null,
        	'status' => 1,
        	'view_product' => 0,
        	'created_at' => date('Y-m-d H:i:s'),
        	'updated_at' => null
        ]);
    }
}
