<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'quantity',
        'total_price'
    ];
     

    public function cart()
    {
        return $this->belongsTo(Cart::class); //Define a relationhip: Cartitem belongs to Cart
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function Product() //Define a relationship: Cartitem belongs to product.
    {
        return $this->belongsTo(Product::class);
    }

    //get the latest products
    public static function getProducts()
    {   
        return self::with('product.images', 'size')->latest();
    }

    //mutators for the price in the cart item
    public function getTotalPriceAttribute($value)
    {
        if(Route::currentRouteName() === 'customer.cart.item.show'){
            return $value;
        }
        return '$' . number_format($value, 2, '.', ',');
    }
    
}