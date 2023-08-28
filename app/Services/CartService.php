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
        $this->cartItemService = $cartItemService;
    }

    public function addItemToCart($data)
    {
        try {
            $user = Auth::user();
            $product = Product::findOrFail($data['product_id']);
            $productPrice = Str::replace('$', '', $product->price);
            $totalPrice = $productPrice * (int)$data['quantity'];
            
            $itemData = [
                'product_id' => $product->id,
                'size' => $data['size'],
                'quantity' => $data['quantity'],
                'total_price' =>  $totalPrice
            ];
            
            $this->cartItemService->createCartItem($user->cart, $itemData);

        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }
}