<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payments extends Model
{
    protected $table = 'orders';

    public function insertOrders($data)
    {
    	$insert = DB::table('orders')->insert($data);
    	if($insert){
    		return true;
    	}
    	return false; 
    }
}
