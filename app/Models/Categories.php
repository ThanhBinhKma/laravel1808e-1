<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    // tao phuong thuc de lien ket moi quan hen many-to-many
    public function products()
    {
    	return $this->belongsToMany('App\Models\Products');
    }

    public function getAllDataCategories()
    {
    	$data = Categories::all();
    	if($data){
    		$data = $data->toArray();
    	}
    	return $data;
    }
}
