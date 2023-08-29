<?php
namespace App\Services;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Services\CartItemService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartService {

    protected $cartItemService;

    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService; //store the CartItemService class 
    }

    public function addItemToCart($data)
    {
        //business logic for adding product to cart
        try {
            $user = Auth::user(); //instantiate the authenticated user
            $product = Product::findOrFail($data['product_id']); //find the product that will  be adding to cart
            $productPrice = Str::replace('$', '', $product->price); //remove the dollar to the price
            $totalPrice = $productPrice * (int)$data['quantity']; //Multiple price base on the quantity
            
            //Initialize the product data to be fetch to the cart
            $itemData = [
                'product_id' => $product->id,
                'size' => $data['size'],
                'quantity' => $data['quantity'],
                'total_price' =>  $totalPrice
            ];
            
            //Handle the creation of the cart items
            $this->cartItemService->createCartItem($user->cart, $itemData);

        } catch(Exception $e){

            //Log the error if something went wrong of adding the product
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }
}