<?php

namespace Tests\Browser;

use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;


class UsersCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function users_can_create_statuses()
    {   
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body','Mi primer status')
                    ->press('#btnCreateStatus')
                    ->waitForText('Mi primer status')
                    ->assertSee('Mi primer status');
        });
    }
}
