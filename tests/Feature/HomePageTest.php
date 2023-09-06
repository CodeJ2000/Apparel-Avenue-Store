<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Testing\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected $productService;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
        $this->productService = new ProductService(new Product);
    }
    public function test_homepage_contains_empty_featured_products()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);

        $response->assertSee('No featured products avaiable!');
    }

    public function test_homepage_contains_empty_new_arrival_products()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);

        $response->assertSee('No new products arival!');
    }

    public function test_homepage_contains_non_empty_featured_products()
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

        $featuredProduct = Product::first();

        $response = $this->get(route('home'));

        $response->assertViewHas('featuredProducts', function($collection) use ($featuredProduct){
            return $collection->contains($featuredProduct);
        });
        
        $response->assertStatus(200);
    }

    public function test_homepage_contains_non_empty_new_arrival_products()
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

        $newArrivalProduct = Product::latest()->first();

        $response = $this->get(route('home'));

        $response->assertViewHas('newArrivalProducts', function($collection) use ($newArrivalProduct){
            return $collection->contains($newArrivalProduct);
        });
    }
}