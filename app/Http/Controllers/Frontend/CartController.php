<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Products;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends BaseController
{
    public function addCart(Request $request, Products $pd)
    {
    	if($request->ajax()){
    		$id = $request->id;
    		$qty = $request->qty;
    		$infoPd = $pd->getInfoDataProductById($id);
    		if($infoPd){
    			// tien hanh add san pham vao gio hang
    			Cart::add([
    				'id' => $id,
    				'name' => $infoPd['name_product'],
    				'qty' => $qty,
    				'price' => $infoPd['price'],
    				'options' => [
    					'images' => json_decode($infoPd['image_product'], true)
    				]
    			]);
    			echo "OK";
    		} else {
    			echo "FAIL";
    		}
    	}
    }
}
