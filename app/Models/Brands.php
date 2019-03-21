<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
	// chi dinh file model nay lam viec voi bang du lieu nao
    protected $table = 'brands';

    // tao phuong thuc de lien ket quan he voi model khac
    public function products()
    {
    	// y dinh : phuong thuc se lien ket quan he one - to - many voi bang product
    	return $this->hasMany('App\Models\Products');
    }

    public function testOneToMany()
    {
    	return Brands::find(1)->products;
    }

    public function getAllDataBrands()
    {
        $data = Brands::all();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
    
}
