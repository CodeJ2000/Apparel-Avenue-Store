<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.pages.products');
    }

    public function getProducts()
    {
        $products = Product::with('category')->select(['id','name', 'description', 'price', 'category_id', 'created_at']);
        // return response()->json($products);
            return DataTables::eloquent($products)
                                ->toJson();
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        
        $products = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);


        $this->handleImages($request, $products);

        return response()->json(['message' => 'Successfuly added']);
    }

     // Function to handle uploading and managing images for a product
    private function handleImages(Request $request, $product)
    {

        // Check if any images are uploaded in the request
        if($request->hasFile('images')){


            $images = $request->file('images');

            // Loop through each uploaded image
            foreach($images as $index => $image){
                if($image){
                    
                    // If the product already has images at this index, replace them
                    if($product->images->count() > $index){

                        // Delete the existing image file from storage and database
                        Storage::disk('public')->delete('product_images/' . $product->images[$index]->filename);
                        $product->images[$index]->delete();

                        // Generate a unique filename and store the new image
                        $fileName = uniqid() . "." .$image->getClientOriginalExtension();
                        $image->storeAs('public/product_images/', $fileName);

                        // Create a new image record in the database
                        $product->images()->create(['image_url' => $fileName]);
                    } else {
                        // If the product doesn't have an image at this index, create a new one
                        $fileName = uniqid() . "." .$image->getClientOriginalExtension();
                        $image->storeAs('public/product_images/', $fileName);

                        // Create a new image record in the database
                        $product->images()->create(['image_url' => $fileName]);
                    }
                }
            }
        }
    }

    public function edit($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['error' => "No data retrieve for edit"]);
        }
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validated();

        $product = Product::find($id);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id']
        ]);

        $this->handleImages($request, $product);
        return response()->json(['message' => 'Successfuly updated']);
    }

}