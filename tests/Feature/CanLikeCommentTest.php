<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanLikeCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_like_comments()
    {
        $comments = Comment::factory()->create();

        $response = $this->postJson(route('comments.likes.store', $comments));

        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_like_and_unlike_comments()
    {
        $user   = User::factory()->create();
        $comments = Comment::factory()->create();

        $this->assertCount(0, $comments->likes);

        $this->actingAs($user)->postJson( route('comments.likes.store', $comments) ); // Actuando como usuario indicado hacemos un POST JSON
        
        $this->assertCount(1, $comments->fresh()->likes);

        $this->assertDatabaseHas('likes', ['user_id' => $user->id]);
        
        $this->actingAs($user)->deleteJson( route('comments.likes.destroy', $comments) );

        $this->assertJson(0, $comments->fresh()->likes);

        $this->assertDatabaseMissing('likes', ['user_id' => $user->id]);

    }

}
