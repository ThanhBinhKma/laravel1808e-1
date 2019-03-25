<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    // chi dinh file model nay lam viec voi bang du lieu nao
    protected $table = 'products';

    public function brands()
    {
    	// tao moi quan he one-to-many voi Brands
    	return $this->belongsTo('App\Models\Brands');
    }

    public function categories()
    {
    	return $this->belongsToMany('App\Models\Categories');
    }

    public function sizes()
    {
    	return $this->belongsToMany('App\Models\Sizes');
    }

    public function colors()
    {
    	return $this->belongsToMany('App\Models\Colors');
    }

    public function addDataProduct($data)
    {
        if(DB::table('products')->insert($data)){
            return true;
        }  
        return false;
    }

    public function getAllDataProduct()
    {
        $data = Products::select('products.*', 'brands.brand_name')
                ->join('brands','brands.id','=','products.brands_id')
                ->get();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
}
