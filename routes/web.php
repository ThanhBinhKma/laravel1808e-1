<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/hello',function(){
	return 'Hello word';
});

Route::get('/hi-you',function(){
	return "This is valentine day !";
});

/************** method GET  ******************/
Route::get('/test',function(){
	return "This is test";
});
// /test : request cua nguoi dung gui len
// ::get() : phuong thuc gui du lieu
// return "This is test"; : respone tra ket qua ve

/****** method POST ****************/
Route::post('/demo-post',function(){
	return "This is method post";
});

/***** method DELETE ***********/
Route::delete('/demo-delete', function(){
	return "This is method delete";
});

/******* method PUT ************/
Route::put('/method-put',function(){
	return "This is method PUT";
});

// chap moi phuong thuc cho 1 request
Route::any('/demo-any',function(){
	return "This is method ANY";
});

// chap nhan 1 hoac nhieu phuong thuc cho 1 request
Route::match(['get','post','put'],'/all-in-one',function(){
	return "This is match Routes";
});

Route::get('/quynh-bup-be-t1',function(){
	// dieu huong trang
	// header('Location:domain')
	return redirect('nguoi-phan-xu-t1');
});

Route::get('/nguoi-phan-xu-t1',function(){
	return "nguoi phan xu tap 1";
})->name('npx');

Route::get('/film-superman',function(){
	// dieu huong trang
	// header('Location:domain')
	return redirect()->route('npx');
});

// route view
Route::get('/demo-view',function(){
	return view('demo');
});

// truyen tham so vao router
// tham so bat buoc - phai truyen vao request khi gui du lieu len server
Route::get('/sam-sung/{name}/{price}',function($namePhone,$pricePhone){
	return "ban dang xem dien thoai {$namePhone} - gia ban la : {$pricePhone}";
});
// tham so khong bat buoc
Route::get('/apple/{name?}/{price?}',function($name = null, $price = null){
	return "Ban dang xem dien thoai iphone : {$name} - Gia ban la : {$price}";
});
// validate tham so routes

// tuoi chi duoc phep nhap so
// ten chi la cac chu cai
Route::get('/check-age/{age}/{name}',function($age,$name){
	return "my age is {$age} - my name  is {$name}";
})->where(['age'=>'[0-9]+','name' => '[A-Za-z]+']);

// name routes
Route::get('/home-page-1',function(){
	return view('home-page');
})->name('homePage');

Route::get('/contact-page',function(){
	return "This is contact page";
})->name('contactPage');

// routes group
// Route::group([
// 	'prefix' => 'admin',
// 	'as' => 'admin.'
// ],function(){

// 	Route::get('/home',function(){
// 		return "admin - home";
// 	})->name('home');

// 	Route::get('/product',function(){
// 		return "admin - Product";
// 	})->name('product');
// });

// Route::get('/login',function(){
// 	return redirect()->route('admin.home');
// });

Route::get('/watch-film/{age}',function($age){
	return redirect()->route('qbb');
})->name('watchFilm')
  ->where('age','[0-9]+')
  ->middleware('myCheckAge');

Route::get('/quynh-bup-be-t10',function(){
	return "chuc ban xem phim vui ve";
})->name('qbb');

Route::get('do-not-watch-film',function(){
	return "ban chua du tuoi de vao xem";
})->name('cancleFilm');

Route::get('/kt-snt/{number}',function($num){

});

Route::get('/result-ok',function(){
	return "OK";
});

Route::get('/result-fail',function(){
	return "Fail";
});

Route::get('demo-controller','DemoController@index');

Route::get('/demo-home/{name}/{age}','DemoController@test')->name('test-controlelr');

Route::get('demo-view','TestController@index')->name('home-view');

Route::post('demo-login','TestController@login')->name('loginForm');
Route::get('tes-request','TestController@test');
Route::get('about-view','AboutController@index')->name('about-view');
Route::get('contact-view','ContactController@index')->name('contact-view');

// su dung middleware trong controller
Route::get('middleware-controller/{user}/{pass}','ExampleController@index')->name('exp');

Route::get('/error-login',function(){
	return "user or pass invalid";
})->name('error-login');

Route::get('info-me','ExampleController@info')->name('info-me');

/************** Query db ****************/
Route::group([
	'prefix' => 'db'
],function(){
	Route::get('query-get','TestQueryBuilderController@index')->name('queryGet');
	Route::get('orm-get','TestQueryBuilderController@orm')->name('ormGet');
	Route::get('one-to-many','TestQueryBuilderController@oneToMany')->name('oneToMany');

	Route::get('many-to-many','TestQueryBuilderController@manyToMany')->name('manyToMany');
});

/****************** Router Admin ******************************/
Route::group([
	'prefix' => 'admin',
	'as' => 'admin.',
	'namespace' => 'Admin'
],
function(){
	Route::get('login','LoginController@loginView')->name('loginView');
	Route::post('handle-login','LoginController@handleLogin')->name('handleLogin');
	Route::post('logout','LoginController@logout')->name('logout');
});
  
Route::group([
	'prefix' => 'admin',
	'as' => 'admin.',
	'namespace' => 'Admin',
	'middleware' => ['adminLogined','web']
],
function(){
	Route::get('dashboard','DashboardController@index')->name('dashboard');
	Route::get('products','ProductController@index')->name('products');
	Route::get('add-product','ProductController@addProduct')->name('addProduct');
	Route::post('handle-add-product','ProductController@handleAddProduct')->name('handleAddProduct');
	Route::post('delete-product','ProductController@deleteProduct')->name('deleteProduct');
	Route::get('edit-product/{id}','ProductController@editProduct')->name('editProduct')->where(['id'=>'[0-9]+']);

	Route::post('handle-edit-product/{id}','ProductController@handleEditProduct')
				->name('handleEditProduct')
				->where(['id'=>'[0-9]+']);
});

/******************** Router Frontend - User **************************/

Route::group([
	'namespace' => 'Frontend',
	'as' => 'fr.'
],function(){
	Route::get('/','ProductController@index')->name('product');
	Route::get('/detail-product/{id}','ProductController@detail')
	      ->name('detailPd')
	      ->where(['id' => '\d+']);

	Route::post('add-cart','CartController@addCart')->name('addCart');
	Route::get('cart','CartController@showCart')->name('showCart');
	Route::post('delete-cart','CartController@deleteCart')->name('deleteCart');
	Route::post('update-cart','CartController@updateCart')->name('updateCart');
	Route::get('payment-order','PaymentController@payment')->name('payment');

});













