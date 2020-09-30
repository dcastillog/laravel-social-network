<?php

namespace Tests\Browser;

use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;


class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function registered_users_can_login()
    {
        $user = User::factory()->create(['email' => 'testing@email.com']);
        
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('@btn-login')
                    ->assertPathIs('/home') // Verifica que esté en la raíz
                    ->assertAuthenticated(); // Verifica si el usuario ha sido autenticado
        });
    }

    /** @test */
    public function users_cannot_login_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', '')
                    ->press('@btn-login')
                    ->assertPathIs('/login')
                    ->assertPresent('@validation-errors')
                ;
        });
    }
}
