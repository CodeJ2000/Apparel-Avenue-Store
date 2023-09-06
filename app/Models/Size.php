<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Size extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes')->withPivot('stocks');
    }

    public function cartItem()
    {
    }
    public function getNameAttribute($value)
    {
        if(Route::currentRouteName() === 'admin.product.edit'){
            return $value;
        }
        return ucwords($value);
    }
}