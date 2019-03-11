<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admins; // nap model
use App\Models\Brands; // nap model
use App\Models\Colors; // nap model

class TestQueryBuilderController extends Controller
{
	// private $db;
	// public function __construct()
	// {
	// 	$this->db = new Admins;
	// }

    public function index()
    {
    	// thuc thi cau lenh query data o day
    	// "SELECT * FROM admins";
    	// QueryBuilder : truy van co so du lieu theo ngon ngu php - format laravel
    	
    	$data = DB::table('admins')->get();
    	// (***) du lieu tra ve mac dinh la object - php chu khong phai la mang
 
    	//chuyen object ve mang
    	$data = json_decode($data,true);

    	foreach ($data as $key => $val) {
    		//echo $val->id;
    		//echo $val['id'];
    		//echo "<br/>";
    	}

    	$data2 = DB::table('products AS a')
    	            ->select('a.id','a.name_product AS name','a.price')
    	            ->get();
    	// get() ~~ fetchAll()
    	// SELECT a.id, a.name_product AS name, a.price FROM products AS a
    	//dd($data2);
    	

    	/* SELECT a.id, a.name_product AS name, a.price FROM products AS a WHERE a.id = 1 AND name = 'abc'
    	AND qty = 1 OR price > 1000 OR status = 1
    	*/
    	
    	$data3 = DB::table('products AS a')
    	            ->select('a.id','a.name_product AS name','a.price')
    	            // ->where('id',1)
    	            // ->where('name_product','abc')
    	            // ->where('qty',1)
    	            ->where([
    	            	'id' => 1,
    	            	'name_product' => 'abc',
    	            	'qty' => 1
    	            ])
    	            ->orWhere('price','>',1000)
    	            ->orWhere('status',1)
    	            ->first();
    	// first() ~~ fetch()
    	// dd($data3)
    	// max - min -avg
    	// SELECT MAX('price') FROM products
    	//$price = DB::table('products')->max('price');
    	
    	// SELECT MIN('price') FROM products
    	//$price = DB::table('products')->min('price');
    	
    	// SELECT AVG('price') FROM products
    	$id = DB::table('categories')->avg('id');
    	//dd($id);
    	
    	// SELECT count(id) FROM brands
    	//$count = DB::table('brands')->count();
    	//dd($count);
    	
    	// join trong laravel
    	// san pham co id la 1 thuoc nhan hang nao
    	// SELECT a.id, b.name_brand FROM products AS a
    	// INNERJOIN brands AS b ON a.id_brand = b.id 
    	// WHERE a.id = 1
    	
    	$data4 = DB::table('products AS a')
    				->select('a.id AS idProduct','b.brand_name')
    				->join('brands AS b','a.id_brand','=','b.id')
    				->where('a.id',1)
    				->first();
    	// dd($data4);
    	
    	// SELECT name, price FROM products WHERE name LIKE '%Quan%'
    	$data5 = DB::table('products')
    				->select('id','name_product')
    				->where('name_product','like','%Quan%')
    				->get();
    	//dd($data5);
    	
    	// INSERT INTO products('name','price') VALUES('bac',1000);
    	/*
    	$insert = DB::table('colors')->insert([
    		'name_color' => 'Green',
    		'status' => 1,
    		'description' => 'mau xanh hoa binh',
    		'created_at' => date('Y-m-d H:i:s'),
    		'updated_at' => null
    	]);

    	if($insert){
    		echo "OK";
    	} else {
    		echo "Fail";
    	}
    	*/
    	
    	// UPDATE colors SET name_color = 'Violet' WHERE id = 1;
    	/*
    	$update = DB::table('colors')
    	            ->where('id',1)
    	            ->update([
    	            	'name_color' => 'Violet',
    	            	'description' => 'Mau tim mong mo'
    	            ]);
    	if($update){
    		echo "OK";
    	} else {
    		echo "Fail";
    	}
    	*/
    	
    	// DELETE FROM colors WHERE id = 5
    	$del = DB::table('colors')
    			->where('id',5)
    			->delete();
    	if($del){
    		echo "OK";
    	} else {
    		echo "Fail";
    	}

    }

    public function orm(Admins $admin)
    {
    	$data = Admins::getAllDataAdmins();
    	//dd($data);
    	// lay du lieu tu ham getDataAdminById
    	$info = $admin->getDataAdminById(1);

    	$data2 = $admin->getDataAdminByConditions('com');
    	dd($data2);

    	//dd($info['id']);
    	// foreach($data as $key => $item){
    	// 	echo $item['id'];
    	// 	echo "<br/>";
    	// }
    }

    public function oneToMany(Brands $brands)
    {
        $data = $brands->testOneToMany();
        // foreach($data as $key => $item){
        //     var_dump($item);
        // }
        dd($data->toArray());
    }

    public function manyToMany(Colors $colors)
    {
        
    }
}
