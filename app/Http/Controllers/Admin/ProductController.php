<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// su dung model
use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Brands;
use App\Http\Requests\StoreProductsPost;

class ProductController extends Controller
{
    public function index()
    {
    	return view('admin.product.index');
    }

    public function addProduct(Categories $cat, Colors $color, Sizes $size, Brands $brand)
    {
    	$data = [];
    	$data['cat'] = $cat->getAllDataCategories();
    	$data['colors'] = $color->getAllDataColors();
    	$data['sizes'] = $size->getAllDataSizes();
    	$data['brands'] = $brand->getAllDataBrands();

    	// lay du lieu tu bang categories do ra view
    	return view('admin.product.add_view',$data);
    }

    public function handleAddProduct(StoreProductsPost $request)
    {
    	dd($request->all());
    }
}
