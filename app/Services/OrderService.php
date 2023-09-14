<?php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\DataTableService;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderService {

    protected $dataTableService;

    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService = $dataTableService;
    }
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

    //get the orders data and return it in datatable format
    public function getOrderJson()
    {
        $orders = Order::getOrdersData(); //retrieve the orders
       return $this->dataTableService->generateDataTable($orders);
    }

    //Handle the changing status of the order
    public function changeStatus(Order $order, $validation)
    {
        try{    
            //If order don't exist throw a Not Found exceptions
            if(!$order){
                throw new NotFoundHttpException();
            }   
            $order->status = $validation['status']; //update status
            if(!$order->save()){
                return response()->json(['error' => 'Status is not updated'], 422); //if not successfuly save then return a response with 422 error
            }
            return response()->json(['success' => 'Status is successfuly updated'], 200);
        }catch(Exception $e){
            Log::error('An error occured at: ' .$e->getMessage());
        }
    }

    //change status from pending to cancelled
    public function statusCancelation($order)
    {
        try {
            //Check if order does not exists, tho throw a Not foind exceptions
            if(!$order){
                throw new NotFoundHttpException();
            }
            $order->status = "cancelled"; //change status to cancelled
            if(!$order->save()){
                return response()->json(['error' => 'Order is not cancelled, Please try again later'], 422);
            }
            return response()->json(['success' => 'Order has successfuly cancelled'], 200);
        } catch(Exception $e){
            Log::error('An error occured at:' . $e->getMessage());
        }
    }

    
    public function statusDelivered($order)
    {
        try {
            if(!$order){
                throw new NotFoundHttpException();
            }
            $order->status = "delivered";
            if(!$order->save()){
                return response()->json(['error' => 'Order is not set to delivered, Please try again later'], 422);
            }
            return response()->json(['success' => 'Order has successfuly set to delivered'], 200);
        } catch(Exception $e){
            Log::error('An error occured at:' . $e->getMessage());
        }
    }
}