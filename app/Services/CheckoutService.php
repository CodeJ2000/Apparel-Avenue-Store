<?php
namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Order;
use Stripe\StripeClient;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutService {
    
    protected $orderService;
    protected $calculationService;
    protected $stripe;

    public function __construct(CalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
    }

    //handle the checkout functionalities
public function processCheckout(User $user)
    {   
        //transfer cart items into order_items
        $order = new Order();
        try{
            $itemData = $this->cartItemToOrderItem($user, $order);            
            $checkout_session = $this->stripe_payment($itemData->line_items);
            
            $amount = $this->calculationService->calculateTax($itemData->totalAmount); //calculate total amount with taxes
            $total_amount = $this->calculationService->removeDollar($amount->totalAmount);
            $addedTax = $this->calculationService->removeDollar($amount->calculatedTax); 
            // dd($this->removeDollar($amount->totalAmount));
            $order->tax = $addedTax; //store added tax
            $order->total_amount = $total_amount; //store total amount with tax added 
            $order->session_id = $checkout_session->id;
            $order->save(); //save it
            
            DB::commit();
            return $checkout_session;
        } catch(Exception $e){
            DB::rollBack();
            Log::error('An error occured at:' . $e->getMessage()); //log the errors if something goes wrong.
        }
    }

    private function stripe_payment($line_items)
    {
        

        $session = $this->stripe->checkout->sessions->create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('customer.checkout.success', [], true),
            'cancel_url' => route('customer.checkout.cancel', [], true),
        ]);

        return $session;

    }

    private function cartItemToOrderItem(User $user, Order $order)
    {
        $order->user_id = $user->id;
            $order->save();
            $totalAmount = 0; //initialize total amount with default value of zero
            $line_items = [];
            DB::beginTransaction();
            $cartItems = $user->cart->cartItems; //get all items in the cart

            //Loop all cart items and store item in the order_items table each loop item
            foreach($cartItems as $cartItem){
                $product_price = $this->calculationService->removeDollar($cartItem->product->price);
                $total_price = $this->calculationService->removeDollar($cartItem->total_price);

                $orderItem = new OrderItem([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'product_price' => $product_price,
                    'total_price' => $total_price,

                ]); //instantiate Orderitem model

                $line_items[] = [
                    'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cartItem->product->name,
                    ],
                    'unit_amount' => $product_price * 100,
                    ],
                    'quantity' => $cartItem->quantity,
                ];
                
                $order->orderItems()->save($orderItem);

                $totalAmount += (int)$total_price; //store the total price in the total amount variable.
            }

            $data = (object)[
                'line_items' => $line_items,
                'totalAmount' => $totalAmount
            ];
            return $data;
    }

}