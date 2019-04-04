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

    public function getAllDataProduct($keyword = '')
    {
        $data = Products::select('products.*', 'brands.brand_name')
                ->join('brands','brands.id','=','products.brands_id')
                ->where('products.name_product','LIKE','%'.$keyword.'%')
                ->orWhere('products.price', 'LIKE' , '%'.$keyword.'%')
                ->paginate(2);
        // if($data){
        //     $data = $data->toArray();
        // }
        return $data;
    }

    public function deleteProductById($id)
    {
        $del = DB::table('products')
                   ->where('id',$id)
                   ->delete();
        return $del;
    }

    public function getInfoDataProductById($id)
    {
        $data = Products::find($id);
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }

    public function updateDataProductById($data, $id)
    {
        $up = DB::table('products')
                    ->where('id',$id)
                    ->update($data);
        return $up;
    }

    public function getDataProductForUser()
    {
        $data = Products::select('*')
                ->paginate(2);
        return $data;
    }
}
