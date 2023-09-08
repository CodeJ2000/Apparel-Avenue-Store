<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'street',
        'barangay',
        'city',
        'province',
        'postal_code'
    ];

    //shipping address belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}