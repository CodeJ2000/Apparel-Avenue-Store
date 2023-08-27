<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    //Define a many to many relationship with sizes, including pivot data (stocks)
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')->withPivot('stocks');
    }


    // Define an accessor: Get formatted price attribute
    public function getPriceAttribute($value)
    {
        //check if the route is product edit form
        if(Route::currentRouteName() === 'admin.product.edit'){
            return number_format($value, 2, '.', ','); // return price without $

        }
            // For other routes, return the price with the dollar sign
            return '$' . number_format($value, 2, '.', ',');
    }
    
    //custom static method to get all products with category information
    public static function getAllProducts()
    {
        return self::with('category')->select(['id','name', 'description', 'price', 'stocks',  'category_id', 'created_at']);
    }

    //custom static method to get a specified number of new products
    public static function getNewProducts($limit = 8)
    {
        return self::with('category')->latest()->take($limit)->get();
    }

    //custom static method to get specified number of featured products
    public static function getFeaturedProducts($limit = 8)
    {
        return self::with('category')->inRandomOrder()->take($limit)->get();
    }

    //custom static method to paginate products with catgory information
    public static function getProductPaginate($paginate = 16)
    {
        return self::with('category')->inRandomOrder()->paginate($paginate);
    }
}