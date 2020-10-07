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
    public function an_authenticated_user_can_like_and_unlike_statuses()
    {
        $user   = User::factory()->create();
        $status = Status::factory()->create();

        //assert like

        $this->assertCount(0, $status->likes); //0 == $status-likes->count()

        $response = $this->actingAs($user)->postJson( route('statuses.likes.store', $status) ); // Actuando como usuario indicado hacemos un POST JSON
        
        $response->assertJsonFragment([
            'likes_count' => 1
        ]);
        
        /*  Verifica en la base de datos que hay un tabla llamada likes 
            Que dentro exista un user_id y status_id igual a los indicados
        **/
        $this->assertCount(1, $status->fresh()->likes); //refresca la peticion y verifica 1 == $status->likes->count()

        $this->assertDatabaseHas('likes', ['user_id' => $user->id]);

        //assert unlike

        $response = $this->actingAs($user)->deleteJson( route('statuses.likes.destroy', $status) ); // Actuando como usuario indicado hacemos un POST JSON
        

        $response->assertJsonFragment([
            'likes_count' => 0
        ]);

        $this->assertCount(0, $status->fresh()->likes);

        $this->assertDatabaseMissing('likes', ['user_id' => $user->id]);

    }
}
