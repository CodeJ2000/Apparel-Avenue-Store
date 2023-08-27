<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new user using the User model
        $user = User::create([
            'first_name' => 'customer',
            'last_name' => 'customer',
            'email' => 'customer@customer.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        
        // Assign the 'customer' role to the created user
        $user->assignRole('customer');
        $user->cart()->save(new Cart());
    }
}