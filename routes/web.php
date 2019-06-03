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

Route::get('/', 'IndexController@index')->name('indexpage');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products/{slug}', 'FrontController@products')->name('products');
Route::get('/product/{id}', 'FrontController@product')->name('single.products');
Route::post('product/get-product-price', 'ProductController@getProductPrice');
// cart page
Route::match(['get', 'post'], '/add-cart', 'CartController@addtoCart')->name('addtocart');
Route::match(['get', 'post'], '/cart', 'CartController@cart')->name('cart');
Route::get('/cart/delete-product/{id}', 'CartController@deleteCart')->name('delete.cart');
Route::get('/cart/update-quantity/{id}/{quantity}', 'CartController@updateCartQuantity')->name('update.cart');
//Coupons
Route::post('/cart/apply-coupon', 'CouponsController@applyCoupon')->name('apply.coupon');

// Register
Route::match(['get', 'post'], '/login-register', 'UsersController@register')->name('login.register');

Route::post('/user-login', 'UsersController@userLogin')->name('user.login');
Route::get('/user-logout', 'UsersController@userlogout')->name('user.logout');




//Route::get('/adminLogin', 'AdminController@login')->name('admin.login');
Route::match(['get', 'post'], '/adminLogin', 'AdminController@login')->name('admin.login');
Route::group(['middleware' => ['frontlogin']], function(){
  Route::match(['get', 'post'], '/account', 'UsersController@account')->name('account');
});

Route::group(['middleware' => ['auth']], function(){
	// Admin login
Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
Route::get('/admin/profile/{id}', 'AdminController@profile')->name('admin.profile');
Route::post('/admin/update/profile/{id}', 'AdminController@update')->name('admin.update');


// category
Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory')->name('category.add');
Route::get('/admin/view-categories','CategoryController@viewCategories')->name('category.view');
Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory')->name('category.edit');
Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory')->name('category.delete');
// product

Route::match(['get', 'post'], 'admin/add-product', 'ProductController@addProduct')->name('product.add');
Route::get('/admin/view-products', 'ProductController@viewProducts')->name('product.view');
Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductController@editProduct')->name('product.edit');
Route::get('/admin/delete-product/{id}', 'ProductController@deleteProduct')->name('product.delete');

// product Attributs
 Route::match(['get', 'post'], '/admin/add-attribute/{id}', 'ProductController@addAttributes')->name('product.addattribute');
Route::get('/admin/delete-attribute/{id}', 'ProductController@deleteAttribute')->name('delete.attribute');
Route::get('/admin/delete-product-image/{id}', 'ProductController@deleteProductImage')->name('delete-productimage');


        // alternet Image
Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductController@addImages')->name('alt.image');
Route::get('/admin/delete-alt-image/{id}', 'ProductController@deleteAltImage')->name('alt.delete');
Route::match(['get', 'post'], '/admin/edit-attribute/{id}', 'ProductController@editAttributes')->name('edit.attribute');
// coupons
    Route::match(['get', 'post'], '/admin/add-coupon', 'CouponsController@addCoupon')->name('add.coupon');
    Route::get('/admin/view-coupons', 'CouponsController@viewCoupons')->name('view.coupons');
     Route::match(['get', 'post'], '/admin/edit-coupon/{id}', 'CouponsController@editCoupon')->name('edit.coupon');
    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');















});


Route::get('/logout', 'AdminController@logout')->name('admin.logout');