<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// The ProductImage class extends the Eloquent Model class
class ProductImage extends Model
{
    use HasFactory;

    // Define the fillable attributes that can be mass-assigned
    protected $fillable = [
        'product_id',   // ID of the associated product
        'image_url',    // URL of the product image
    ];

    // Define a relationship: a ProductImage belongs to a Product
    public function product()
    {
        return $this->belongsTo(Product::class); // Return the Product model instance
    }

    // Define an accessor: Get formatted image URL attribute
    public function getImageUrlAttribute($value): string
    {
        return 'storage/product_images/' . $value; // Return the formatted image URL
    }
}