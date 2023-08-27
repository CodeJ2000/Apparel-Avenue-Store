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
        $this->productService = $productService; //store Productservice class
    }
    public function index()
    {
        try{
        
            //Get featured products and new arrival products using productservice
            $featuredProducts = Product::getFeaturedProducts();
            $newArrivalProducts = Product::getNewProducts();

            //Load the index view and pass the featured and new arrival products
            return view('index', ['featuredProducts' => $featuredProducts, 'newArrivalProducts' => $newArrivalProducts]);
        
        } catch(Exception $e){
        
            Log::error('An error occured at: ' . $e->getMessage());
        
        }
    }
    
}