<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function index()
    {
        return view('single-product');
    }
}