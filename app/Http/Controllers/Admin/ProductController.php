<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// su dung model
use App\Models\Categories;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Brands;
use App\Models\Products;
use App\Http\Requests\StoreProductsPost;

class ProductController extends Controller
{
    public function index(Request $request, Products $pd, Categories $cat, Colors $color, Sizes $size)
    {
        $data = [];
        $data['mess'] = $request->session()->get('addPd');
        $data['cat'] = $cat->getAllDataCategories();
        $data['sizes'] = $size->getAllDataSizes();
        $data['colors'] = $color->getAllDataColors();

        $data['lstPd'] = $pd->getAllDataProduct();
        foreach($data['lstPd'] as $key => $item) {
            $data['lstPd'][$key]['categories_id'] = json_decode($item['categories_id'],true);
            $data['lstPd'][$key]['colors_id'] = json_decode($item['colors_id'],true);
            $data['lstPd'][$key]['sizes_id'] = json_decode($item['sizes_id'],true);
        }

        foreach($data['lstPd'] as $key => $item){
           foreach($data['cat'] as $k => $val){
                if(in_array($val['id'], $item['categories_id'])){
                    $data['lstPd'][$key]['categories_id']['name_cat'][] = $val['name'];
                }
           }  
        }

        foreach($data['lstPd'] as $key => $item){
           foreach($data['colors'] as $k => $val){
                if(in_array($val['id'], $item['colors_id'])){
                    $data['lstPd'][$key]['colors_id']['name_color'][] = $val['name_color'];
                }
           }
        }

        foreach($data['lstPd'] as $key => $item){
           foreach($data['sizes'] as $k => $val){
                if(in_array($val['id'], $item['sizes_id'])){
                    $data['lstPd'][$key]['sizes_id']['name_size'][] = $val['letter_size'];
                }
           }
        }

    	return view('admin.product.index',$data);
    }

    public function addProduct(Categories $cat, Colors $color, Sizes $size, Brands $brand, Request $request)
    {
    	$data = [];
    	$data['cat'] = $cat->getAllDataCategories();
    	$data['colors'] = $color->getAllDataColors();
    	$data['sizes'] = $size->getAllDataSizes();
    	$data['brands'] = $brand->getAllDataBrands();
        $data['mess'] = $request->session()->get('addPd');

    	// lay du lieu tu bang categories do ra view
    	return view('admin.product.add_view',$data);
    }

    public function handleAddProduct(StoreProductsPost $request, Products $pd)
    {
    	//dd($request->all());
        // lay cac du lieu tu form nguoi dung gui len
        $nameProduct = $request->nameProduct;
        $categories  = $request->cat;
        $colors = $request->color;
        $sizes = $request->size;
        $brand = $request->brands;
        $price = $request->price;
        $qty = $request->qty;
        $sale = $request->sale;
        $description = $request->description;
        $arrNameFile = [];

        // thuc hien upload file
        // kiem tra xem nguoi co chon file ko
        if($request->hasFile('images')){
            // lay thong tin cua file
            $files = $request->file('images');
            // mang dinh nghia cac file hop le
            $extension = ['png','jpg','gif','jepg'];

            foreach ($files as $key => $item) {
                // lay ra duoc ten file va duong dan luu tam thoi cua file tren may cua nguoi dung
                $nameFile = $item->getClientOriginalName();
                // lay ra duoi file (phan mo rong cua file)
                $exFiles = $item->getClientOriginalExtension();
                // kiem tra co hop le hay ko thi cho upload
                if(in_array($exFiles, $extension)){
                    // tien hanh upload
                    // public_path() : di vao thuc muc public
                    // trong thu muc public : neu chua ton tai thu muc upload va thu muc images thi no tu dong tao
                    $item->move(public_path().'/upload/images',$nameFile);
                    $arrNameFile[] = $nameFile;
                }
            }
        }
        // tien hanh luu thong vao db
        if($arrNameFile){
            // luu vao db
            // json_encode : bien mang thanh chuoi json - object trong js
            $dataInsert = [
                'name_product' => $nameProduct,
                'categories_id' => json_encode($categories),
                'colors_id' => json_encode($colors),
                'sizes_id' => json_encode($sizes),
                'brands_id' => $brand,
                'price' => $price,
                'qty' => $qty,
                'description' => $description,
                'image_product' => json_encode($arrNameFile),
                'sale_off' => $sale,
                'status' => 1,
                'view_product' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null
            ];
            if($pd->addDataProduct($dataInsert)){
                $request->session()->flash('addPd','success');
                return redirect()->route('admin.products');
            } else {
                $request->session()->flash('addPd','Fail');
                return redirect()->route('admin.addProduct');
            }
        } else {
            $request->session()->flash('addPd','Can not upload image');
            return redirect()->route('admin.addProduct');
        }
    }
}
