<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{
    protected $table = 'sizes';

    public function products()
    {
    	return $this->belongsToMany('App\Models\Products');
    }

    public function getInfoSizeByArrid($arrId = [])
    {
        $data = Sizes::select('*')
                      ->whereIn('id',$arrId)
                      ->get();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }

    public function getAllDataSizes()
    {
        $data = Sizes::all();
        if($data){
            $data = $data->toArray();
        }
        return $data;
    }
}
