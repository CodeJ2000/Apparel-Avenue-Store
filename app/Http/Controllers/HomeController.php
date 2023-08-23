<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try{
            $featuredProducts = $this->getFeaturedProducts();
            $newArivalProducts = $this->getNewProducts();
            return view('index', ['featuredProducts' => $featuredProducts, 'newArivalProducts' => $newArivalProducts]);
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    private function getFeaturedProducts()
    {
        try{
            $products = Product::with('category')->inRandomOrder()->take(8)->get();
            return $products;
        }catch(Exception $e){
            Log::error('An error occured: ' . $e->getMessage());
        }
        
    }

    private function getNewProducts()
    {
        try{
            $products = Product::with('category')->orderBy('created_at', 'desc')->take(8)->get();
            return $products;
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }
}