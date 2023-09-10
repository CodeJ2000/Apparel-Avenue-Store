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

    //handle the checkout payment process
    public function checkout()
    {
        $user = Auth::user();
        $checkout_session = $this->checkoutService->processCheckout($user);   
        return redirect($checkout_session->url);
    }

    //Handle the success logic if the checkout success
    public function success(Request $request)
    {
        $session_id = $request->get('session_id');

        $this->checkoutService->successStripe($session_id);
        return view('customer.checkout-success');
    }

    //Handle the cancel if the user cancel the checkout
    public function cancel()
    {
        return redirect()->back();
    }
}