<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function getSizes()
    {
        $sizes = Size::all();
        return response()->json($sizes);
    }




}