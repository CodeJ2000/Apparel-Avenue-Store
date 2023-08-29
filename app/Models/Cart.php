<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class); //Define a relationship: Cart belongs to User
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class); //Define a relationship: Cart has many Cartitems
    }
}