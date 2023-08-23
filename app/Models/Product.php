<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// The Product class extends the Eloquent Model class
class Product extends Model
{
    use HasFactory; // Enable factory support for model
    use SoftDeletes; // Enable soft deletion for the model

    // Define the fillable attributes that can be mass-assigned
    protected $fillable = [
        'name',             // Product name
        'description',      // Product description
        'price',            // Product price
        'category_id'       // ID of the associated category
    ];

    // Define a relationship: a Product belongs to a Category
    public function category()
    {

        return $this->belongsTo(Category::class); // Return the Category model instance
    }

    // Define a relationship: a Product has many ProductImages
    public function images()
    {
        return $this->hasMany(ProductImage::class); // Return a collection of ProductImage instances
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    // Define an accessor: Get formatted price attribute
    public function getPriceAttribute($value)
    {
        return '$' . number_format($value, 2, '.', ','); // Format price with dollars and comma separation
    }
}