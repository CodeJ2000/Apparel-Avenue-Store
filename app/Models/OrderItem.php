<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'product_price',
        'total_price',
    ];

    //Order items belongs to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductPriceAttribute($value)
    {
        if(Route::currentRouteName() === "customer.orders.items.show"){
            return '$ ' . number_format($value, 2, '.', ',');
        }

        return $value;
    }

    
    public function getTotalPriceAttribute($value)
    {
        if(Route::currentRouteName() === "customer.orders.items.show"){
            return '$ ' . number_format($value, 2, '.', ',');
        }
        return $value;
    }

    public static function allOrders()
    {
        return self::latest()->get();
    }

    public static function orderProducts($orderId)
    {
        return self::with(['product.images', 'order'])
                    ->where('order_id', $orderId)
                    ->get();
    }

}