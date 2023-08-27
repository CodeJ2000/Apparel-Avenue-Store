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
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('shop', [ShopController::class, 'index'])->name('shop');
Route::get('blog', [BlogController::class, 'index'])->name('blog');
Route::get('about', [AboutController::class, 'index'])->name('about');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::get('product/{product}', [SingleProductController::class, 'index'])->name('single.product');

Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/signup', [SignupController::class, 'index'])->name('signup.create');
Route::post('/signup', [SignupController::class, 'signup'])->name('signup.store');

Route::get('/sizes', [SizeController::class, 'getSizes'])->name('get.sizes.json');
Route::get('product/{product}/size/{size}', [SingleProductController::class, 'getSizeStocks'])->name('stocks.get');

Route::prefix('customer')->middleware(['auth', 'role:customer'])->group(function(){
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::get('order', [CustomerOrderController::class , 'index'])->name('customer.order');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function(){
    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('index');
    Route::resource('/roles', RoleController::class);
    Route::resource('/permissions', PermissionController::class); 
    Route::get('products/list', [AdminProductController::class, 'getProducts'])->name('product.json');
    Route::post('product/store', [AdminProductController::class, 'store'])->name('product.store');
    Route::get('products', [AdminProductController::class, 'index'])->name('products');
    Route::post('product/{product}', [AdminProductController::class, 'update'])->name('product.update');
    Route::get('product/{product}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::post('product/{product}/delete', [AdminProductController::class, 'destroy'])->name('product.destroy');
    Route::get('products/categories/list', [CategoryController::class, 'getCategories'])->name('category.get.json');

    Route::get('category/list', [CategoryController::class, 'categoriesDataTable'])->name('categories');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::post('category/{id}/delete', [CategoryController::class, 'destroy'])->name('category.destroy'); 
});