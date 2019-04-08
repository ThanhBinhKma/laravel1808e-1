<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Sizes;
use App\Models\Colors;

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

    public function detail($id, Request $request, Products $pd, Sizes $size, Colors $color, Categories $cate)
    {
    	// lay thong tin cua san pham
    	$infoPd = $pd->getInfoDataProductById($id);
    	if($infoPd){
    		$arrColor = json_decode($infoPd['colors_id'], true);
    		$arrSize = json_decode($infoPd['sizes_id'], true);
    		$arrImage = json_decode($infoPd['image_product'],true);

    		$infoColor = $color->getInfoColorByArrId($arrColor);
    		$infoSize  = $size->getInfoSizeByArrid($arrSize);
    		$data = [];
    		$data['info'] = $infoPd;
    		$data['images'] = $arrImage;
    		$data['colors'] = $infoColor;
    		$data['sizes'] = $infoSize;
    		$data['cate'] = $this->getAllDataCategoriesForUser($cate);

    		return view('frontend.product.detail',$data);

    	} else {
    		abort(404);
    	}
    }
}
