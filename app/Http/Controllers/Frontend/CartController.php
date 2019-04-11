<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Products;
use App\Models\Categories;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends BaseController
{
    public function deleteCart(Request $request)
    {
        $id = $request->id;
        Cart::remove($id);
        echo "OK";
    }

    public function updateCart(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        Cart::update($id, $qty);
        echo "OK";
    }

    public function showCart(Categories $cate)
    {
        $data = [];
        $data['cate'] = $this->getAllDataCategoriesForUser($cate);
        // lay thong tin trong gio hang de show ra ngoai layout view
        $data['cart'] = Cart::content();
        return view('frontend.cart.showCart',$data);
    }

    public function addCart(Request $request, Products $pd)
    {
    	if($request->ajax()){
    		$id = $request->id;
    		$qty = $request->qty;
            $color = $request->color;
            $size = $request->size;

    		$infoPd = $pd->getInfoDataProductById($id);
    		if($infoPd && is_numeric($qty) && $color && $size){
    			// tien hanh add san pham vao gio hang
    			Cart::add([
    				'id' => $id,
    				'name' => $infoPd['name_product'],
    				'qty' => $qty,
    				'price' => $infoPd['price'],
    				'options' => [
    					'images' => json_decode($infoPd['image_product'], true),
                        'color' => $color,
                        'size' => $size
    				]
    			]);
    			echo "OK";
    		} else {
    			echo "FAIL";
    		}
    	}
    }
}
