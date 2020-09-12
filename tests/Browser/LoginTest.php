<?php

namespace Tests\Browser;

use App\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function registered_users_can_login()
    {
        factory(User::class)->create(['email' => 'test@email.com']);
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email','test@email.com')
                    ->type('password', 'password')
                    ->press('#login-btn')
                    ->assertPathIs('/') // Verifica que esté en la raíz
                    ->assertAuthenticated(); // Verifica si el usuario ha sido autenticado
        });
    }
}
