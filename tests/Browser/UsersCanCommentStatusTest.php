<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Status;
use App\Models\Comment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanCommentStatusTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_all_comments()
    {
        $status = Status::factory()->create();
        $comments = Comment::factory()->count(2)->create(['status_id' => $status->id]);

        $this->browse(function (Browser $browser) use ($status, $comments) {
            $browser->visit('/home')
                    ->waitForText($status->body);
                     
            foreach($comments as $comment)
            {
                $browser->assertSee($comment->body)
                        ->assertSee($comment->user->name);
            }
        });
    }

    /** @test */
    public function authenticated_users_can_comment_statuses()
    {   
        $user = User::factory()->create();
        $status = Status::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $comment = 'Test comment';

            $browser->loginAs($user)
                    ->visit('/home')
                    ->waitForText($status->body)
                    ->type('comment', $comment)
                    ->press('@btn-comment')
                    ->waitForText($comment)
                    ->assertSee($comment);
                        
        });
    }
}
