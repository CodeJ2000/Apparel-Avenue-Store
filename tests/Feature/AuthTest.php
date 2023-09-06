<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
   use RefreshDatabase;
    
   public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }
    public function test_user_can_login()
    {
        $user = User::first();
        $response = $this->actingAs($user)->post(route('authenticate'),[
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

}