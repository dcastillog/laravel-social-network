<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Status;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanGeTheirNotificationsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    // public function users_can_see_their_notifications_in_the_navbar()
    // {
    //     $user = User::factory()->create();
    //     $status = Status::factory()->create();
    //     $notification = DatabaseNotification::factory()->create([
    //         'notifiable_id' => $user->id,
    //         'data' => [
    //             'message' => 'Haz recibido un like',
    //             'link' => route('statuses.show', $status)
    //         ]
    //     ]);

    //     $this->browse(function (Browse $browser) use ($user, $notification, $status) {
    //         $browser->loginAs($user)
    //                 ->visit('/')
    //                 ->resize(1024, 768)
    //                 ->click("@notifications")
    //                 ->assertSee('Haz recibido un like')
    //                 ->click("@{$notification->id}") 
    //                 ->assertUrlIs($status->path()) 
                    
    //                 ->click("@notifications")
    //                 ->press("@mark-as-read-{$notification->id}")
    //                 ->waitFor("@mark-as-unread-{$notification->id}")
    //                 ->assertMissing("@mark-as-read-{$notification->id}")

    //                 ->press("@mark-as-unread-{$notification->id}")
    //                 ->waitFor("@mark-as-read-{$notification->id}")
    //                 ->assertMissing("@mark-as-unread-{$notification->id}")
    //         ;
    //     });
    // }

    /** @test */
    public function users_can_see_their_like_notifications_in_real_time()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $status = Status::factory()->create(['user_id' => $user1]);

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user1, $user2, $status) {
            $browser1->loginAs($user1)
                    ->visit('/home')
                    ->resize(1024,768)
            ;

            $browser2->loginAs($user2)
                    ->visit('/home')
                    ->waitForText('ME GUSTA')
                    ->press('@btn-like')
                    ->pause(1000)
            ;

            $browser1->assertSeeIn('@notifications-count', 1);

        });
    }

    /** @test */
    public function users_can_see_their_comment_notifications_in_real_time()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $status = Status::factory()->create(['user_id' => $user1]);

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user1, $user2, $status) {
            $browser1->loginAs($user1)
                    ->visit('/home')
                    ->resize(1024,768)
            ;

            $browser2->loginAs($user2)
                    ->visit('/home')
                    ->waitForText('ME GUSTA')
                    ->type('comment', 'Mi comentario')
                    ->press('@btn-comment')
                    ->pause(2000)
            ;

            $browser1->assertSeeIn('@notifications-count', 1);

        });
    }
}
