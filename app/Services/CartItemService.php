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
    
    //create item on the cart by adding product to cart 
    public function createCartItem(Cart $cart, $itemData)
    {
        try{
            $productId = $itemData['product_id']; //get the id of the product
        //handle the creation of the product
            $productExist = $cart->cartItems->where('product_id', $productId)->first(); //find the product match the product id

            //check if the product doesn't exist
            if(!$productExist){
                $cart->cartItems()->create($itemData); //add the product to the cart
                $successMesage = "Successfuly added to cart"; //success message
            } else {
                $productExist->update($itemData); // if product exist in the cart, update the product item
                $successMesage = 'Product in the cart is successfuly updated'; //success message
            }
            return $successMesage; //return the the success message
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage()); //Log the error if something went wrong
        }
    }

    //get the products in pagination
    public function paginateProducts($limit)
    {
        return $this->cartItemModel::getProducts()->paginate($limit);     
    }

    //calculate and format the price
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

    //get the single item in the cart
    public function getSingleCartItem(CartItem $cartItem)
    {

        $product = $cartItem->load('product.images', 'product.category', 'size', 'product.sizes');
        return $product;
    }
}