<?php 
namespace App\Services;

use App\Models\Cart;

class CartItemService {
    
    public function createCartItem(Cart $cart, $itemData)
    {
        $cart->cartItems()->create($itemData);
    }

}