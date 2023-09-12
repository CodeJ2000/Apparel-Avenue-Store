<?php

namespace App\Http\Controllers\Customer;

use Exception;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    //return the order page
    public function index()
    {
        return view('customer.order');
    }

    //Get the orders to display in the dataTable
    public function getOrders()
    {
        $user = Auth::user();
        try{
            $orders = $user->orders()->latest();
            return DataTables::eloquent($orders)
            ->toJson();
        } catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    //It will return the related product of the orders
    public function showOrderProducts(Order $order)
    {
        $product_items = $this->orderService->getOrderProducts($order);
        return response()->json($product_items);
    }
}