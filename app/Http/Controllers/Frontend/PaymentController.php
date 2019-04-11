<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Categories;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController extends BaseController
{
    public function payment(Categories $cate)
    {
    	$data = [];
    	$data['cate'] = $this->getAllDataCategoriesForUser($cate);
    	$data['cart'] = Cart::content();

    	return view('frontend.payment.index', $data);
    }
}
