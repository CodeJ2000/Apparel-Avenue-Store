<?php
namespace App\Services;

use Exception;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Str;
use App\Services\CartItemService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\ShippingAddressService;

class CartService {

    protected $cartItemService;
    protected $shippingAddressService;
    public function __construct(CartItemService $cartItemService, ShippingAddressService $shippingAddressService)
    {
        $this->cartItemService = $cartItemService; //store the CartItemService class 
        $this->shippingAddressService = $shippingAddressService;
    }

    public function displayProducts($limit)
    {
        $cartItems = $this->cartItemService->paginateProducts($limit); //Cart items with paginated
        $subTotal = $this->cartItemService->subTotalPrice(); //subtotal price of all items in the cart
        $totalWithTaxAdded = $this->calculateTax($subTotal); // final amount with tax added 
        $shippingAddress = $this->shippingAddressService->getUserShippingAddress();
        //include all the result in the data objects
        $data = (object) [
            'cartItems' => $cartItems,
            'calculatePrice' => (object)[
                'subTotal' => $subTotal,
                'totalWithTaxAdded' => $totalWithTaxAdded
            ],
            'shippingAddress' => $shippingAddress
        ];
        return $data; //return the object
    }

    //calculate the subtotal with tax
    public function calculateTax($amount)
    {
        $amount = str_replace(['$', ','], '', $amount); //Remove the dollar symbol and comma in the price
        $calculatedTax = (float)$amount * 0.12; // multiply the amount with the 12% tax rate
        $total = $amount + $calculatedTax; //Sum up the multiplied tax rate to the amount price
        $total = '$' . number_format($total, 2, '.', ','); // Format the total price with dollar symbol and comma for thousands
        $calculatedTax = '+ $' . number_format($calculatedTax, 2, '.', ','); //Format the calculated tax with  the dollar symbol and comma for thousand

        //Include the result in to the data object
        $data = (object) [
            'totalAmount' => $total,
            'calculatedTax' => $calculatedTax
        ];

        //return the object
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

    //paginate the product returned
    public function paginateProducts($limit)
    {
        return $this->cartItemService->paginateProducts($limit);
    }

    //get single cart item
    public function getSingleCartItem(CartItem $cartItem)
    {
        $product = $this->cartItemService->getSingleCartItem($cartItem);
        return $product;
    }
}