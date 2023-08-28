<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'quantity',
        'total_price'
    ];
     

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
}