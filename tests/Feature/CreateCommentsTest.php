<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Status;

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
}
