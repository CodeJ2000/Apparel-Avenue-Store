<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckoutService {
    
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    //handle the checkout functionalities
    public function processCheckout(User $user)
    {   
        //transfer cart items into order_items
        $this->orderService->createOrder($user);
    }
}