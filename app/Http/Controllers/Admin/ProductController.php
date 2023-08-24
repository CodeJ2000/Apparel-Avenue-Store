<?php

namespace App\Http\Controllers\Admin;
use App\Models\Size;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{


    public function index()
    {
        return view('admin.pages.products');
    }

    public function getProducts()
    {
        $products = Product::getAllProducts();
            return DataTables::eloquent($products)
                                ->toJson();
    }

    public function store(ProductRequest $request)
    {
        
        $validated = $request->validated();
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);
        $this->handleSizes($product, $request->sizes);


        $this->handleImages($request, $product);

        return response()->json(['message' => 'Successfuly added']);
    }

    private function handleSizes(Product $product, $sizes)
    {
        foreach($sizes as $sizeName => $stock){
            $size = Size::where('name', $sizeName)->first();
            if($size){
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_id' =>$size->id,
                    'stocks' => $stock
                ]);
                
            }
        }   
       
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
        
        $selectedData = $product->only(['name', 'description', 'price', 'category_id']);
        
        return response()->json($selectedData);
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            
            $product = Product::findOrFail($id);
            $product->name = $validated['name'];
            $product->description = $validated['description'];
            $product->price = $validated['price'];
            $product->category_id = $validated['category_id'];
            $product->save();
    
            $this->handleImages($request, $product);
    
            return response()->json(['message' => 'Successfully updated']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating product'], 500);
        }
    }

    public function destroy($id){

        try {
            $product = Product::find($id);

            $product->delete();
            return response()->json(['status' => 200, 'data' => 'product']);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException();
        }
    }
}