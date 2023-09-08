<?php
namespace App\Services;

use Exception;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderService {

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    //Create order or transfer cart items to the orders
    public function createOrder(User $user)
    {
        $order = new Order();
        try{
            $order->user_id = $user->id; //store user id to order table in column user_id
            $order->save(); // then save


            $cartItems = $user->cart->cartItems; //get all items in the cart
            $totalAmount = 0; //initialize total amount with default value of zero

            //Loop all cart items and store item in the order_items table each loop item
            foreach($cartItems as $cartItem){
                $orderItem = new OrderItem(); //instantiate Orderitem model
                $orderItem->order_id = $order->id; // store order id.
                $orderItem->product_id = $cartItem->product_id; //store product id
                $orderItem->quantity = $cartItem->quantity; // store item quantity
                $orderItem->product_price = $this->removeDollar($cartItem->product->price); //store product price
                $orderItem->total_price = $this->removeDollar($cartItem->total_price); // store total price of  multiplied product price to quantity
                
                $totalAmount += (int)$this->removeDollar($cartItem->total_price); //store the total price in the total amount variable.

                //check if order item is save, if true then delete the item from the cart_items table
                if($orderItem->save()){
                    $cartItem->delete(); 
                }
            }

            
            $amount = $this->cartService->calculateTax($totalAmount); //calculate total amount with taxes
            $total_amount = $this->removeDollar($amount->totalAmount);
            $addedTax = $this->removeDollar($amount->calculatedTax); 

            // dd($this->removeDollar($amount->totalAmount));
            $order->tax = $addedTax; //store added tax
            $order->total_amount = $total_amount; //store total amount with tax added 
            $order->save(); //save it

            return true;
        } catch(Exception $e){
            Log::error('An error occured at:' . $e->getMessage()); //log the errors if something goes wrong.
        }
    }
    
    public function updateOrderStatus()
    {

    }
    
    //remove the dollar, comma, space and + in the price
    private function removeDollar($value)
    {
        return str_replace(['$', ',', ' ', '+'], '', $value);
    }
}