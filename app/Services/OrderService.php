<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService {

    //Get the related products of the order
    public function getOrderProducts(Order $order)
    {
        
        try{
            //check if the order not exist
            if(!$order){
                throw new NotFoundHttpException(); //throw a not found exceptions
            }
            $orderItems = $order->orderItems; //get the order item of the order
            $product_items = OrderItem::orderProducts($order->id); //get the products
        
            return $product_items; //return the product retrieved

        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }
}