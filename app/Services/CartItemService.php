<?php 
namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;

class CartItemService {

    protected $cartItemModel;
    
    public function __construct(CartItem $cartItem)
    {
        $this->cartItemModel = $cartItem;
    }
    
    public function createCartItem(Cart $cart, $itemData)
    {
        try{
            $productId = $itemData['product_id'];
        //handle the creation of the product
            $productExist = $cart->cartItems->where('product_id', $productId)->first();
            if(!$productExist){
                $cart->cartItems()->create($itemData);
                $successMesage = "Successfuly added to cart";
            } else {
                $productExist->update($itemData);
                $successMesage = 'Product in the cart is successfuly updated';
            }
            return $successMesage;
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    public function paginateProducts($limit)
    {
        return $this->cartItemModel::getProducts()->paginate($limit);     
    }

    public function subTotalPrice()
    {   
        $subTotal = 0;
        $total = $this->cartItemModel::getProducts()->sum('total_price');
        if($total){
            $subTotal = '$' . number_format($total, 2, '.', ',');
            return $subTotal;
        }
        return '$' . number_format((int)$subTotal, 2, '.', ',');; 
    }

    public function getSingleCartItem(CartItem $cartItem)
    {

        $product = $cartItem->load('product.images', 'product.category', 'size', 'product.sizes');
        return $product;
    }
}