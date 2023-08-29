<?php 
namespace App\Services;

use App\Models\Cart;

class CartItemService {
    
    public function createCartItem(Cart $cart, $itemData)
    {

        //handle the creation of the product
        $cart->cartItems()->create($itemData);
    }

}