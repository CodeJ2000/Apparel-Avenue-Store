<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'total_price',
        'status',
        'session_id'
    ];

    //Order has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    //Orders belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTaxAttribute($value)
    {
        if(Route::currentRouteName() === 'customer.orders.get.json' || Route::currentRouteName() === 'admin.orders.get.json'){
            return '$ ' . number_format($value, 2, '.', ',');
        }
        return $value;
    } 

    public function getTotalAmountAttribute($value)
    {
        if(Route::currentRouteName() === 'customer.orders.get.json' || Route::currentRouteName() === 'admin.orders.get.json'){
            return '$ ' . number_format($value, 2, '.', ',');
        }
        return $value;
    }
    

    public function getStatusAttribute($value)
    {
        return ucwords($value);
    } 
    //get the order where it has match a session id and status
    public static function getOrderCheckout($session_id, $status)
    {
        return self::where('session_id', $session_id)->where('status', $status)->first();
    }

    public static function getOrdersData()
    {
        return self::with(['user'])
                    ->select(['id', 'user_id', 'tax', 'total_amount', 'status'])
                    ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END, status DESC");
    }
}