<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Testing\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopPageTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }
    
    public function test_shop_page_contains_empty_products()
    {
        $response = $this->get(route('shop'));

        $response->assertStatus(200)
                 ->assertSee('No products available!');
    }

    public function test_shop_page_contains_products()
    {
                // Storage::fake('local');
                $admin = User::whereHas('roles', function($query){
                    $query->where('name', 'admin');
                })->first();       
        
                $this->actingAs($admin);
        
                
                $imageFile = File::create('image.jpg', 100);
                $sizes['Small'] = 67;
                $sizes['Medium'] = 63;
                $sizes['Large'] = 6;
        
                $data = [
                    'name' => 'name',
                    'description' => 'sadsadasdsdasdasd',
                    'price' => 323,
                    'category_id' => 1,
                    'images' => [
                        $imageFile,
                        $imageFile,
                        $imageFile,
                        $imageFile,
                    ],
                    'sizes' => $sizes,
                ];
        
                $this->post(route('admin.product.store'), $data);
                $this->assertDatabaseHas('products', ['name' => 'name']);
        
                $product = Product::first();
        
                $response = $this->get(route('shop'));
        
                $response->assertViewHas('products', function($collection) use ($product){
                    return $collection->contains($product);
                });
    }
}