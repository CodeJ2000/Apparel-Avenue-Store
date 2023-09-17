<?php
namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;

class DashBoardCardsService {


    public function income()
    {
        $total_income = Order::getOrdersExceptUnpaid()->sum('total_amount');
        
        $income = (object)[
            'total_income' => $this->incomeFormat($total_income),
            'todays_income' => $this->incomeFormat($this->todaysEarn())
        ];
        return $income;
    }

    public function todaysEarn()
    {
        $currentDate = Carbon::today();

        return Order::getOrdersExceptUnpaid()->whereDate('created_at', $currentDate)->sum('total_amount');

    }

    public function totalUsers()
    {

    }

    public function todaysUsersSignup()
    {

    }

    public function totalProducts()
    {

    }

    public function soldOutProducts()
    {

    }

    public function totalOrders()
    {

    }

    public function OrdersDelivered()
    {

    }

    private function incomeFormat($value)
    {
        return '$ ' . number_format($value, 2, '.', ',');
    }
}