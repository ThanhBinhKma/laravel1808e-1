<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    protected $table = 'colors';

    public function getInfoColorByArrId($arrId = [])
    {
        $data = Colors::select('*')
                      ->whereIn('id',$arrId)
                      ->get();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }

    public function products()
    {
    	return $this->belongsToMany('App\Models\Products');
    }
    /*
    public function testManyToMany()
    {
    	$data = Colors::find(1)
    	            ->products() 
    	$data = Colors::with('products')->get();

    	if($data){
    		$data = $data->toArray();
    	}
    	return $data;
    }
    */
   
    public function getAllDataColors()
    {
        $data = Colors::all();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
}
