<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SingleProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ShippingAddressController;
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

//Route of the welcome page
Route::get('/', [HomeController::class, 'index'])->name('home');

//Route of products display page
Route::get('shop', [ShopController::class, 'index'])->name('shop');

//Route of the blog page
Route::get('blog', [BlogController::class, 'index'])->name('blog');

//Route of the about page
Route::get('about', [AboutController::class, 'index'])->name('about');

//Route of the contact page
Route::get('contact', [ContactController::class, 'index'])->name('contact');

//Route of the single product page
Route::get('product/{product}', [SingleProductController::class, 'index'])->name('single.product');

//Route of the login page
Route::get('/login', [LoginController::class, 'index'])->name('login.form')->middleware('guest');

//Route of the authenticating th user on the login page
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

//Route of the logout functionality of the user
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//Route of the signup page of the user
Route::get('/signup', [SignupController::class, 'index'])->name('signup.create');

//Route of the registering the user 
Route::post('/signup', [SignupController::class, 'signup'])->name('signup.store');

//Route  of getting the sizes in json format
Route::get('/sizes', [SizeController::class, 'getSizes'])->name('get.sizes.json');

//Route fot getting the stock eacg sizes of the product
Route::get('product/{product}/size/{size}', [SingleProductController::class, 'getSizeStocks'])->name('stocks.get');

//Route group for all route related to customer user
Route::prefix('customer')->middleware(['auth', 'role:customer'])->name('customer.')->group(function(){

    Route::prefix('cart')->group(function(){
            //Route for the cart page of the authenticated customer
        Route::get('/', [CartController::class, 'index'])->name('cart');

        //Route for showing each cart item 
        Route::get('item/{cartItem}/show', [CartController::class, 'getSingleCartItem'])->name('cart.item.show');

        Route::get('table/refresh', [CartController::class, 'refreshTable'])->name('cart.table.refresh');
        Route::post('product/added', [CartController::class, 'store'])->name('product.add_cart');
        Route::post('item/{cartItem}/delete', [CartController::class, 'destroy'])->name('cart.item.destroy');
    });

    Route::prefix('checkout')->group(function(){
        Route::post('/', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    });

    Route::prefix('orders')->group(function(){
        Route::get('/', [CustomerOrderController::class , 'index'])->name('orders');
        Route::get('data', [CustomerOrderController::class, 'getOrders'])->name('orders.get.json');
        Route::get('{order}/items', [CustomerOrderController::class, 'showOrderProducts'])->name('orders.items.show');
        Route::get('{order}/cancel', [CustomerOrderController::class, 'cancelOrder'])->name('orders.cancel');
        Route::get('{order}/delivered', [CustomerOrderController::class, 'deliveredOrder'])->name('orders.delivered');
    });

   

    Route::post('shippingAddress/store', [ShippingAddressController::class, 'addOrUpdate'])->name('shipping_address.store');

});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function(){
    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('index');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class); 
    
    Route::prefix('products')->group(function(){
        Route::get('/', [AdminProductController::class, 'index'])->name('products');
        Route::get('list', [AdminProductController::class, 'getProducts'])->name('product.json');
        Route::post('store', [AdminProductController::class, 'store'])->name('product.store');
        Route::post('{product}', [AdminProductController::class, 'update'])->name('product.update');
        Route::get('{product}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
        Route::post('{product}/delete', [AdminProductController::class, 'destroy'])->name('product.destroy');
        Route::get('categories/list', [CategoryController::class, 'getCategories'])->name('category.get.json');
    });

    Route::prefix('category')->group(function(){
        Route::get('list', [CategoryController::class, 'categoriesDataTable'])->name('categories');
        Route::post('store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::post('{id}/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    Route::prefix('orders')->group(function(){
        Route::get('list', [AdminOrderController::class, 'getOrders'])->name('orders.get.json');
        Route::post('{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status.update');
    });

    Route::prefix('sizes')->group(function(){
        Route::get('/list', [SizeController::class, 'displaySizeDataTable'])->name('sizes.get.json');
    });

});