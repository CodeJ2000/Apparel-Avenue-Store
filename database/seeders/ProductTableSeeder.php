<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1,20) as $index){
            $categoryId = DB::table('categories')->pluck('id');
            DB::table('products')->insert([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(2),
                'price' => $faker->randomFloat(2, 10, 100),
                'category_id' => $faker->randomElement($categoryId),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}