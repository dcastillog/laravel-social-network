<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_register_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'testname')
                    ->type('first_name', 'FirstName')
                    ->type('last_name', 'LastName')
                    ->type('email', 'test@email.com')
                    ->type('password', 'password')
                    ->type('password_confirmation', 'password')
                    ->press('@btn-register')
                    ->assertPathIs('/home')
                    ->assertAuthenticated()
                ;
        });
    }

    /** @test */
    public function users_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', '')
                    ->press('@btn-register')
                    ->assertPathIs('/register')
                    ->assertPresent('@validation-errors')
                ;
        });
    }
}
