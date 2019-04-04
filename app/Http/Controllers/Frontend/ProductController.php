<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Categories;
use App\Models\Products;

class ProductController extends BaseController
{
    public function index(Categories $cate, Products $pd)
    {
    	// load cate
    	$data = [];
    	$data['cate'] = $this->getAllDataCategoriesForUser($cate);
    	$data['listPd'] = $pd->getDataProductForUser();
    	return view('frontend.product.index',$data);
    }
}
