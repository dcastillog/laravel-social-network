<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Status;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanSeeProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_profile_and_statuses()
    {
        $user = User::factory()->create();
        $statuses = Status::factory()->count(2)->create(['user_id' => $user]);
        $otherStatus = Status::factory()->create();
        
        $this->browse(function (Browser $browser) use ($user, $statuses, $otherStatus){
            $browser->visit(route('users.show', $user))
                    ->waitForText($user->name)
                    ->assertSee($user->name)
                    ->waitForText($statuses->first()->body)
                    ->assertSee($statuses->first()->body)
                    ->assertSee($statuses->first()->body)
                    ->assertDontSee($otherStatus->body)
                ;
        });
    }
}
