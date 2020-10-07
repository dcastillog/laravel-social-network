<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Comment;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanLikeCommentTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function users_can_like_and_unlike_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                    ->visit(RouteServiceProvider::HOME)
                    ->waitForText($comment->body)
                    
                    ->assertSeeIn('@comment-likes-count', 0) // se especifica un elemento
                    
                    ->press('@btn-comment-like')
                    ->waitForText('TE GUSTA')
                    ->assertSee('TE GUSTA')
                    ->assertSeeIn('@comment-likes-count', 1)

                    ->press('@btn-comment-like')
                    ->waitForText('ME GUSTA')
                    ->assertSee('ME GUSTA')
                    ->assertSeeIn('@comment-likes-count', 0);
        });
    }

    /** @test */
    public function users_can_see_likes_and_unlikes_in_real_time()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user, $comment) {
            $browser1->visit('/home');

            $browser2->loginAs($user)
                    ->visit('/home')
                    ->maximize()
                    ->waitForText($comment->body)
                    ->assertSeeIn('@comment-likes-count', 0) // se especifica un elemento
                    ->press('@btn-comment-like')
                    ->waitForText('TE GUSTA');

            $browser1->assertSeeIn('@comment-likes-count', 1);

            $browser2->press('@btn-comment-like')
                    ->waitForText('ME GUSTA');

            $browser1->pause(2000)->assertSeeIn('@comment-likes-count', 0);
        });
    }
}
