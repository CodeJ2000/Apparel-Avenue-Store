<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashBoardCardsService {


    // compute the total income and earnings for today
    public function income()
    {
        $total_income = Order::getOrdersExceptUnpaid()->sum('total_amount'); //get the total income
        
        //store in the object array
        $income = (object)[
            'total_income' => $this->incomeFormat($total_income), //assign the total income
            'todays_income' => $this->incomeFormat($this->todaysEarn()) //assign the earning for today
        ];
        return $income; //return the populated object array
    }

    //get the earning for today
    public function todaysEarn()
    {

        return Order::getOrdersExceptUnpaid()->whereDate('created_at', $this->currentDate())->sum('total_amount'); //return the tota earnings for today
    }

    //count the users
    public function usersCount()
    {
        $userTotalCount = User::getUsersData()->count(); //total users
        $userCountData = (object)[
            'usersTotalCount' => $this->countFormat($userTotalCount),
            'todayUsersCount' => $this->countFormat($this->todaysUsersSignup()) 
        ];
        return $userCountData;    
    }

    //count of today users signups
    private function todaysUsersSignup()
    {
        return User::getUsersData()->whereDate('created_at', $this->currentDate())->count();
    }

    //count the products
    public function countProducts()
    {
        $activeProducts = Product::whereNot('stocks', 0)->count(); //total products except the sold out
        $soldOutProducts = $this->soldOutProducts(); //sold out products

        $products = (object)[
            'activeProducts' => $this->countFormat($activeProducts),
            'soldOutProducts' => $this->countFormat($soldOutProducts)
        ];
        return $products;
    }

    //sold out products
    private function soldOutProducts()
    {
        return Product::where('stocks', 0)->count();
    }

    //count the orders
    public function countOrders()
    {
        $activeOrders = Order::whereNot('status', 'delivered')->count(); //total active orders
        $deliveredOrders = $this->ordersDelivered(); //total delivered orders

        $orders = (object)[
            'activeOrders' => $this->countFormat($activeOrders),
            'deliveredOrders' => $this->countFormat($deliveredOrders)
        ];

        return $orders;
    }

    //total delivered orders
    private function ordersDelivered()
    {
        return Order::where('status', 'delivered')->count();
    }

    //format the money 
    private function incomeFormat($value)
    {
        return '$ ' . number_format($value, 2, '.', ',');
    }

    //format the numbers
    private function countFormat($value)
    {
        return (int)number_format($value, 2, '.', ',');
    }


    private function currentDate()
    {
        return Carbon::today();
    }
}