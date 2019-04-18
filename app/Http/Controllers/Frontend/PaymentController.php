<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Categories;
use App\Models\Payments;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\PaymentOrdersPost as Payment;

class PaymentController extends BaseController
{
    public function payment(Categories $cate)
    {
    	$data = [];
    	$data['cate'] = $this->getAllDataCategoriesForUser($cate);
    	$data['cart'] = Cart::content();

    	return view('frontend.payment.index', $data);
    }

    public function payOrder(Payment $request, Payments $pay)
    {
    	// lay thong tin tu form gui len
    	$fullname = $request->username;
    	$email = $request->email;
    	$phone = $request->phone;
    	$address = $request->address;
    	$note = $request->note;

    	$infoPd = Cart::content();

    	$dataInsert = [
    		'fullname' => $fullname,
    		'email' => $email,
    		'phone' => $phone,
    		'address' => $address,
    		'note' => $note,
    		'infoPd' => json_encode($infoPd),
    		'status' => 0, // mac dinh la waiting : 0
    		'created_at' => date('Y-m-d H:i:s'),
    		'updated_at' => null
    	];

    	if($infoPd){
    		// insert vao db
    		$insert = $pay->insertOrders($dataInsert);
    		if($insert){
    			// xoa gio hang di
    			Cart::destroy();
    			return redirect()->route('fr.payment',['state' => 'success']);
    		} else {
    			return redirect()->route('fr.payment',['state' => 'error']);
    		}
    	} else {
    		return redirect()->route('fr.payment',['state' => 'fail']);
    	}
    }
}
