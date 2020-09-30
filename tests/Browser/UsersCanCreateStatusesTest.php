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
                    ->visit('/home')
                    ->type('body','Mi primer status')
                    ->press('#btnCreateStatus')
                    ->waitForText('Mi primer status')
                    ->assertSee('Mi primer status')
                    ->assertSee($user->name);
        });
    }

    /** @test */
    public function users_can_see_statuses_in_real_time()
    {   
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user1, $user2) {
            $browser1->loginAs($user1)
                    ->visit('/home')
            ;
            
            $browser2->loginAs($user2)
                    ->visit('/home')
                    ->type('body','Mi primer status')
                    ->press('#btnCreateStatus')
                    ->waitForText('Mi primer status')
                    ->assertSee('Mi primer status')
                    ->assertSee($user2->name)
            ;

            $browser1->waitForText('Mi primer status')
                    ->assertSee('Mi primer status')
                    ->assertSee($user2->name)
            ;
        });
    }
}
