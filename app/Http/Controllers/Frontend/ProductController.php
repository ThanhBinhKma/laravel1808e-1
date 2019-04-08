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

    	$listPd = $pd->getDataProductForUser();
    	$arrPd = $listPd ? $listPd->toArray() : [];
    	$data['listPd'] = $arrPd['data'] ?? [];
    	$data['link'] = $listPd; 

    	foreach($data['listPd'] as $key => $item){
    		$data['listPd'][$key]['image_product'] = json_decode($item['image_product'],true);
    	}

    	return view('frontend.product.index',$data);
    }
}
