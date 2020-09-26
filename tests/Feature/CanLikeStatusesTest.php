<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Status;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanLikeStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_like_statuses()
    {
        $status = Status::factory()->create();

        $response = $this->postJson(route('statuses.likes.store', $status));

        $response->assertStatus(401);
    }
    
    /** @test */
    public function an_authenticated_user_can_like_statuses()
    {
        $user   = User::factory()->create();
        $status = Status::factory()->create();

        $this->actingAs($user)->postJson( route('statuses.likes.store', $status) ); // Actuando como usuario indicado hacemos un POST JSON
        
        /*  Verifica en la base de datos que hay un tabla llamada likes 
            Que dentro exista un user_id y status_id igual a los indicados
        **/
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $status->id
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_unlike_statuses()
    {
        $user   = User::factory()->create();
        $status = Status::factory()->create();

        $this->actingAs($user)->postJson( route('statuses.likes.store', $status) ); // Actuando como usuario indicado hacemos un POST JSON
        
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $status->id
        ]);
        
        $this->actingAs($user)->deleteJson( route('statuses.likes.destroy', $status) );
        
    }
}
