<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }
    public function testLoginEmptyInputShowValidationErrors(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee("You don't have an account?")
                ->type('email', '')
                ->type('password', '')
                ->scrollIntoView("You don't have an account? Signup Now")
                ->press('Login')
                ->assertSee('The email field is required.')
                ->assertSee('The password field is required.');
        });
    }
    

    
    public function testLoginWrongEmailTypeShowValidationErrors(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee("You don't have an account?")
                    ->type('#email', 'jomardas')
                    ->type('#password', 'password')
                    ->scrollIntoView("You don't have an account? Signup Now")
                    ->press('Login')
                    ->pause(4000)
                    ->assertPathIs('/login');

        });
    }


    public function testAdminLoginRedirectToAdminDashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee("You don't have an account?")
                    ->type('#email', 'admin@admin.com')
                    ->type('#password', 'password')
                    ->scrollIntoView("You don't have an account? Signup Now")
                    ->press('Login')
                    ->pause(4000)
                    ->assertPathIs('/admin/dashboard');

        });
    }

    public function testCustomerLoginRedirectToWelcomePage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee("You don't have an account?")
                    ->type('#email', 'customer@customer.com')
                    ->type('#password', 'password')
                    ->scrollIntoView("You don't have an account? Signup Now")
                    ->press('Login')
                    ->pause(4000)
                    ->assertPathIs('/');

        });
    }
}