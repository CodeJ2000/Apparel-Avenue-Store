<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    //get the orders in datatable json format
    public function getOrders()
    {
        return $this->orderService->getOrderJson();
    }

    
    public function updateStatus(Order $order, OrderStatusRequest $request)
    {
        $validation = $request->validated();
        return $this->orderService->changeStatus($order, $validation);       
    }
}