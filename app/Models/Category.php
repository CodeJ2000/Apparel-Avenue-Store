<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    // This category has many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function getAll()
    {
        return self::query()->select('id', 'name', 'created_at')->get();
    }
}