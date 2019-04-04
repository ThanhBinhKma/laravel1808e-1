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
        $keyword = trim($request->q);

        $data = [];
        $data['mess'] = $request->session()->get('addPd');
        $data['cat'] = $cat->getAllDataCategories();
        $data['sizes'] = $size->getAllDataSizes();
        $data['colors'] = $color->getAllDataColors();

        $lstPd = $pd->getAllDataProduct($keyword);
        $arrPd = ($lstPd) ? $lstPd->toArray() : [];
        $data['lstPd'] = $arrPd['data'];
        $data['link']  = $lstPd;

        foreach($data['lstPd'] as $key => $item) {
            // xu ly cat
            $data['lstPd'][$key]['categories_id'] = json_decode($item['categories_id'],true);
            // xu ly color
            $data['lstPd'][$key]['colors_id'] = json_decode($item['colors_id'],true);
            // xu ly size
            $data['lstPd'][$key]['sizes_id'] = json_decode($item['sizes_id'],true);
            // xu ly images product
            $data['lstPd'][$key]['image_product'] = json_decode($item['image_product'],true);
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
        //dd($data['lstPd']);
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

    public function deleteProduct(Request $request, Products $pd)
    {
        if($request->ajax()){
            // dung la ajax gui len thi moi xu ly
            $id = $request->id;
            $del = $pd->deleteProductById($id);
            if($del){
               echo "OK"; 
            } else {
                echo "FAIL";
            }
        }
    }

    public function editProduct($id, Request $request, Products $pd, Categories $cat, Colors $color, Sizes $size, Brands $brand)
    {
        $id = is_numeric($id) ? $id : 0;
        // lay thong tin san pham theo id
        $infoPd = $pd->getInfoDataProductById($id);
        if($infoPd){
            $data = [];
            $data['cat'] = $cat->getAllDataCategories();
            $data['colors'] = $color->getAllDataColors();
            $data['sizes'] = $size->getAllDataSizes();
            $data['brands'] = $brand->getAllDataBrands();
            $data['info'] = $infoPd;

            $data['infoCat'] = json_decode($infoPd['categories_id'],true);
            $data['infoColor'] = json_decode($infoPd['colors_id'],true);
            $data['infoSize'] = json_decode($infoPd['sizes_id'],true);
            $data['infoImage'] = json_decode($infoPd['image_product'],true);
            //dd($infoPd);

            return view('admin.product.edit_view',$data);
        } else {
            abort(404);
        }
    }

    public function handleEditProduct(StoreProductsPost $request, Products $pd)
    {
        // lay cac du lieu tu form nguoi dung gui len
        $id = $request->id;
        $infoPd = $pd->getInfoDataProductById($id);
        if($infoPd){
            $nameProduct = $request->nameProduct;
            $categories  = $request->cat;
            $colors = $request->color;
            $sizes = $request->size;
            $brand = $request->brands;
            $price = $request->price;
            $qty = $request->qty;
            $sale = $request->sale;
            $description = $request->description;
            // nhung anh ban dau khi add - truoc khi edit san pham
            $arrNameFile  = json_decode($infoPd['image_product'],true);
            $arrNameFile2 = [];

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
                        $arrNameFile2[] = $nameFile;
                    }
                }

            }
            $arrNameFile = ($arrNameFile2) ? $arrNameFile2 : $arrNameFile;

            if($arrNameFile){
                $dataUpdate = [
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
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $up = $pd->updateDataProductById($dataUpdate, $id);
                if($up){
                    $request->session()->flash('editPd','update successful');
                    return redirect()->route('admin.products');
                } else {
                    $request->session()->flash('editPd','Can not update');
                    return redirect()->route('admin.editProduct',['id'=>$id]);
                }
            } else {
                $request->session()->flash('editPd','Can not upload image');
                return redirect()->route('admin.editProduct',['id'=>$id]);
            }
        } else {
            abort(404);
        }
    }
}
