<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = $this->getProducts();
        return view('shop', compact('products'));
    }

    private function getProducts()
    {
        $products = Product::with('category')->inRandomOrder()->paginate(16);
        return $products;
    }
}