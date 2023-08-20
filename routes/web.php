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
use App\Http\Controllers\Admin\ProductController as AdminProductController;
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
Route::get('product', [SingleProductController::class, 'index'])->name('single.product');

Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/signup', [SignupController::class, 'index'])->name('signup.create');
Route::post('/signup', [SignupController::class, 'signup'])->name('signup.store');


Route::prefix('customer')->middleware('customer')->group(function(){
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::get('order', [CustomerOrderController::class , 'index'])->name('customer.order');
});

Route::prefix('admin')->group(function(){
    Route::get('dashboard', [AdminHomeController::class, 'index'])->name('admin.index');
     
    Route::get('products/list', [AdminProductController::class, 'getProducts'])->name('admin.product.json');
    Route::post('product/store', [AdminProductController::class, 'store'])->name('admin.product.store');
    Route::get('products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::post('product/{id}', [AdminProductController::class, 'update'])->name('admin.product.update');
    Route::get('product/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('product/{id}/delete', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::get('products/categories/list', [CategoryController::class, 'getCategories'])->name('admin.category.get.json');

    Route::get('category/list', [CategoryController::class, 'categoriesDataTable'])->name('admin.categories');
    Route::post('category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::post('category/{id}/delete', [CategoryController::class, 'destroy'])->name('admin.category.destroy'); 
});