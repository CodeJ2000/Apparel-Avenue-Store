<?php
namespace App\Services;

use App\Models\CartItem;
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

    public function displayProducts($limit)
    {
        $cartItems = $this->cartItemService->paginateProducts($limit);
        $subTotal = $this->cartItemService->subTotalPrice();
        $totalWithTaxDeduction = $this->calculateTax($subTotal);
        $data = (object) [
            'cartItems' => $cartItems,
            'calculatePrice' => (object)[
                'subTotal' => $subTotal,
                'totalWithTaxDeduction' => $totalWithTaxDeduction
            ]
        ];
        return $data;
    }

    private function calculateTax($amount)
    {
        $amount = str_replace(['$', ','], '', $amount);
        $calculatedTax = (float)$amount * 0.12;
        
        $total = $amount + $calculatedTax;
        $total = '$' . number_format($total, 2, '.', ',');
        $calculatedTax = '+ $' . number_format($calculatedTax, 2, '.', ',');
        $data = (object) [
            'totalAmount' => $total,
            'calculatedTax' => $calculatedTax
        ];
        return $data;
    }
    
    public function addOrUpdateItemToCart($data)
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
                'size_id' => (int)$data['size_id'],
                'quantity' => $data['quantity'],
                'total_price' =>  (int)$totalPrice
            ];
            
            //Handle the creation of the cart items
          $cartMessage =  $this->cartItemService->createCartItem($user->cart, $itemData);
        
          return $cartMessage;
        } catch(Exception $e){

            //Log the error if something went wrong of adding the product
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    public function paginateProducts($limit)
    {
        return $this->cartItemService->paginateProducts($limit);
    }

    public function getSingleCartItem(CartItem $cartItem)
    {
        $product = $this->cartItemService->getSingleCartItem($cartItem);
        return $product;
    }
}