<?php
namespace App\Services;

use Exception;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class ProductService 
{
    protected $productModel; //storage 

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel; //store the model instance 
    }

    //method to handle assigning sizes and stocks to a product
    public function handleSizes(Product $product, $sizes)
    {
        $product->sizes()->detach(); //Detach existing size for the product 
        $totalStocks = 0; //initialize total stocks of the product
        //loop through sizez and attach them with stocks to product 
        foreach($sizes as $sizeName => $stock){
            $size = Size::where('name', $sizeName)->first();
            if($size){
                $product->sizes()->attach($size->id, [
                    'stocks' => $stock,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $totalStocks += $stock; //Add stock of the size to the total stocks variable 
            }
        }

        //Add the total stocks to the product stocks column
        $product->stocks = $totalStocks; 
        $product->save();
    }   

    //method to handle uploading and updating product images
    public function handleProductImages(Request $request, $product)
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
 
    //method to get sizes-specific stocks of a product
    public function getSizeStock($product, $size = null)
    {
        try {
            $stocks = $product->stocks; //get the product total stocks

            //check if the size exist
            if($size){
                $stocks = $product->sizes()->find($size->id)->pivot->stocks; //override the stocks value to stock per size

            }
            return $stocks; //return the stocks

        return response()->json(['stocks' => $stocks]);
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }
}