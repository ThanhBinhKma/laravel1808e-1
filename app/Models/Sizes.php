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
}
