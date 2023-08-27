<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductImageService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService; //store the ProductService class 
    }

    public function index()
    {
        //Display the products view in the admin panel
        return view('admin.pages.products');
    }

    //get all products and return then as JSON using datatables
    public function getProducts()
    {
        $products = Product::getAllProducts();
            return DataTables::eloquent($products)
                                ->toJson();
    }


    public function store(ProductRequest $request)
    {
        //Validate the request data         
        $validated = $request->validated();

        //Create an new product using the validated data
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        //Handle sizes and images for a new product
        $this->productService->handleSizes($product, $request->sizes);
        $this->productService->handleProductImages($request, $product);

        return response()->json(['message' => 'Successfuly added']);
    }
    
    
    public function edit(Product $product)
    {
        //Return data for editing a product
        if(!$product){
            return response()->json(['error' => "No data retrieve for edit"]);
        }
        
        //Get basic product data
        $productData = $product->only(['name', 'description', 'price', 'stocks', 'category_id']);
        
        // Get size and stocks for a product
        $sizesWithStocks = [];
        foreach($product->sizes as $size){
            $sizesWithStocks[$size->name] = $size->pivot->stocks;
        }
        $productData['sizes'] = $sizesWithStocks;
        return response()->json($productData);
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            //Validate the request data 
            $validated = $request->validated();
            
            //Update the product with the validated data
            $product->name = $validated['name'];
            $product->description = $validated['description'];
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->save();
    
            //Handle images and sizes for the updating the product
            $this->productService->handleProductImages($request, $product);
            $this->productService->handleSizes($product, $request->sizes);
            return response()->json(['message' => 'Successfully updated']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating product'], 500);
        }
    }

    public function destroy(Product $product){

        try {
            
            //Delete selected product
            $product->delete();
            return response()->json(['status' => 200, 'data' => 'product']);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException();
        }
    }
}