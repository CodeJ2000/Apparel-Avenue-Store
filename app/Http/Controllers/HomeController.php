<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        try{
        
            $featuredProducts = Product::getFeaturedProducts();
            $newArivalProducts = Product::getNewProducts();

            return view('index', ['featuredProducts' => $featuredProducts, 'newArivalProducts' => $newArivalProducts]);
        
        } catch(Exception $e){
        
            Log::error('An error occured at: ' . $e->getMessage());
        
        }
    }
    
}