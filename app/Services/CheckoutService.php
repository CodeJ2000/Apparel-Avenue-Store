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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $order = new Order();
        try{
                         
            $itemData = $this->cartItemToOrderItem($user, $order); //transfer cart items into order_items
            $amount = $this->calculationService->calculateTax($itemData->totalAmount); //calculate total amount with taxes
            $total_amount = $this->calculationService->removeDollar($amount->totalAmount); //store the total amount with tax added
            $addedTax = $this->calculationService->removeDollar($amount->calculatedTax); //calculate the sub total price with tax
            
            $checkout_session = $this->stripe_payment($itemData->line_items, $addedTax); //initialize the checkout using stripe, and return the stripes object
            
            // dd($this->removeDollar($amount->totalAmount));
            $order->tax = $addedTax; //store added tax
            $order->total_amount = $total_amount; //store total amount with tax added 
            $order->session_id = $checkout_session->id; //store the session id of the stripe in the order table
            $order->save(); //save it
            
            DB::commit();
            return $checkout_session; //return the checkout session object
        } catch(Exception $e){
            DB::rollBack();
            Log::error('An error occured at:' . $e->getMessage()); //log the errors if something goes wrong.
        }
    }

    //Handle the checkout with stripe
    private function stripe_payment($line_items, $addedTax)
    {
        // dd($addedTax * 100);
        $line_items[] = [
            'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'VAT-12% added tax',
            ],
            'unit_amount' => $addedTax * 100,
            ],
            'quantity' => 1,
        ];        
        try {
            //Prepare the checkout session
            $session = $this->stripe->checkout->sessions->create([
                'line_items' => $line_items, // all product items that will be checkout
                'mode' => 'payment',
                'success_url' => route('customer.checkout.success', [], true), // redirect to success route if success.
                'cancel_url' => route('customer.checkout.cancel', [], true), //Redirect to back to cart if cancel.
            ]);
    
            return $session; // return the session
    
        }catch(Exception $e){
            Log::error('An error occured at:' . $e->getMessage());
        }
    }


    private function cartItemToOrderItem(User $user, Order $order)
    {
           try {
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
                
                if($order->orderItems()->save($orderItem)){
                    $cartItem->delete();
                }

                $totalAmount += (int)$total_price; //store the total price in the total amount variable.
            }

            $data = (object)[
                'line_items' => $line_items,
                'totalAmount' => $totalAmount
            ];
            return $data;
           } catch(Exception $e){
                Log::error('An error occured at: ' . $e->getMessage());
                throw new NotFoundHttpException();
           }
    }


}