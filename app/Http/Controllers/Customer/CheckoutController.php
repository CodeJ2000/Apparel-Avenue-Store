<?php

namespace App\Http\Controllers\Customer;

use Exception;
use App\Models\Order;
use Stripe\StripeClient;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\CalculationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $checkoutService;
    protected $calculationService;
    public function __construct(CheckoutService $checkoutService, CalculationService $calculationService)
    {
        $this->checkoutService = $checkoutService; 
        $this->calculationService = $calculationService;
    }

    public function checkout()
    {
        $user = Auth::user();
        $checkout_session = $this->checkoutService->processCheckout($user);   
        return redirect($checkout_session->url);
    }

    
    public function success()
    {
        return view('customer.checkout-success');
    }
    public function cancel()
    {
        return back();
    }
}