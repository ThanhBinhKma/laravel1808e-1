<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
    	// nap view vao trong  ung dung
    	
    	// return : response ket qua 
    	// view(): respone ve 1 view (chua ma html)
    	$name = 'LPHP1808E';
    	$age = 20;
    	$address = 'Ha Noi';

    	$data = [];
    	$data['name'] = $name;
    	$data['age']  = $age;
    	$data['address'] = $address;

    	$data['finfoST'] = [
    		[
    			'msv' => 113,
    			'name' => 'Ngyen Van A',
    			'age' => 20,
    			'email' => 'nguyenvana@gmail.com',
    			'gender' => 1,
    			'money' => 2000000
    		],
    		[
    			'msv' => 114,
    			'name' => 'Ngyen Van B',
    			'age' => 20,
    			'email' => 'nguyenvanb@gmail.com',
    			'gender' => 0,
    			'money' => 3000000
    		],
    		[
    			'msv' => 115,
    			'name' => 'Ngyen Van C',
    			'age' => 19,
    			'email' => 'nguyenvanc@gmail.com',
    			'gender' => 1,
    			'money' => 1000000
    		]
    	];

    	// truyen bien ra ngoai view - truyen bien don
    	//return view('test.index')->with('myName',$name);


    	// truyen bien ra ngoai view - truyen 1 mang
    	return view('test.index',$data);
    }

    public function login(Request $request){
    	// doi tuong Request : luu cac thong tin request tu phia client gui len
    	$username = $request->input('user');
    	// var_dump + die
    	dd($username);
    }
}
