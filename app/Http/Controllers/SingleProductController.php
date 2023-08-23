<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function index(Product $product)
    {
        return view('single-product', compact('product'));
    }
}