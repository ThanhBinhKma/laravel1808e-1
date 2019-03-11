<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
