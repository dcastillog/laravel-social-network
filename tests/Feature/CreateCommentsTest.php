<?php

namespace Tests\Feature;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;
use App\Models\Status;
use App\Events\CommentCreated;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_cannot_create_comments()
    {
        $status = Status::factory()->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->postJson( route('statuses.comments.store', $status), $comment);   
        $response->assertStatus(401);
    }


    /** @test */
    public function authenticated_users_can_comment_statuses()
    {
        $user = User::factory()->create();
        $status = Status::factory()->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->actingAs($user)
            ->postJson( route('statuses.comments.store', $status), $comment);

        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment['body']
        ]);
    }

    /** @test */
    public function a_comment_requires_a_body()
    {
        $status = Status::factory()->create();
        $user = User::factory()->create();
        
        $this->actingAs($user);
 
        $response = $this->postJson(route('statuses.comments.store', $status), ['body' => '']);
        
        $response->assertStatus(422); // 422: Entidad no procesable
        
        $response->assertJsonStructure([ // Verifica solo la estructura del JSON
            'message', 'errors' => ['body']
        ]);

    }

    /** @test */
    public function an_event_is_fired_when_a_comment_is_created()
    {
        Event::fake([CommentCreated::class]); 

        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        $user = User::factory()->create();
        $status = Status::factory()->create();
        $comment = ['body' => 'Mi primer comentario'];

        $this->actingAs($user)
            ->postJson( route('statuses.comments.store', $status), $comment);

        Event::assertDispatched(CommentCreated::class, function($commentStatusEvent){
            
            $this->assertInstanceOf(CommentResource::class, $commentStatusEvent->comment);
            
            $this->assertTrue(Comment::first()->is($commentStatusEvent->comment->resource)); // Assert Instancia y Id

            $this->assertEventChannelType('public', $commentStatusEvent);
            $this->assertEventChannelName("statuses.{$commentStatusEvent->comment->status_id}.comments", $commentStatusEvent);
            $this->assertDontBroadcastToCurrentUser($commentStatusEvent);

            return true;
        }); //verificamos que se dispare el evento y hacemos verificacion
    }
}
