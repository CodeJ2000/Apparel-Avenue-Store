<?php
namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class SingleProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Product $product)
    {
        return view('single-product', compact('product'));
    }

    public function getSizeStocks(Product $product, Size $size)
    {
        $stocks = $this->productService->getSizeStock($product, $size);

        return response()->json($stocks);
    }
    
}