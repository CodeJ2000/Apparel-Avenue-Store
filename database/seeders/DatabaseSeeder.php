<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        //To populate my database tables with dummy data 
        $this->call([
            CategorySeeder::class,
            SizeSeeder::class,
            RoleTableSeeder::class,
            AdminSeeder::class,
            CustomerSeeder::class,
        ]);

    }
}