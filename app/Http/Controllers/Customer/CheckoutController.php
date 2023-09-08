<?php

namespace App\Http\Controllers\Customer;

use Exception;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService; 
    }

    public function checkout()
    {
        $user = Auth::user();

        $this->checkoutService->processCheckout($user);
        
    }
}