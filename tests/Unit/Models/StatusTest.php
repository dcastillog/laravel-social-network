<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Status;
use App\Models\Like;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_belongs_to_a_user()
    {
        $status = Status::factory()->create();

        $this->assertInstanceOf(User::class, $status->user);  //Verifica si un objeto es una instancia de una determinada clase
    }

    /** @test */
    public function a_status_has_many_likes()
    {
        $status = Status::factory()->create();
        $like = Like::factory()->create(['status_id' => $status->id]);

        $this->assertInstanceOf(Like::class, $status->likes->first());
    }

    /** @test */
    public function a_status_can_be_liked_and_unlike()
    {
        $status = Status::factory()->create();

        $this->actingAs(User::factory()->create());
        
        $status->like();

        $this->assertEquals(1, $status->fresh()->likes->count()); // Verifica que el estado tenga un likee

        $status->unlike();

        $this->assertEquals(0, $status->fresh()->likes->count()); //fresh cache
    }

    /** @test */
    public function a_status_can_be_liked_once()
    {
        $status = Status::factory()->create();

        $this->actingAs(User::factory()->create());
        
        $status->like();
        $this->assertEquals(1, $status->likes->count()); 

        $status->like();
        $this->assertEquals(1, $status->fresh()->likes->count()); // por default se obtiene datos del cache, fresh() vuelve a ejecutar la consulta 
    }

    /** @test */
    public function a_status_knows_if_has_been_liked_and_unliked()
    {
        $status = Status::factory()->create();

        $this->assertFalse($status->isLiked());
        
        $this->actingAs(User::factory()->create());
        
        $this->assertFalse($status->isLiked());

        $status->like();

        $this->assertTrue($status->isLiked());
    }

    /** @test */
    public function a_status_knows_how_many_likes_it_has()
    {
        $status = Status::factory()->create();
        
        $this->assertEquals(0, $status->likesCount());

        Like::factory()->count(2)->create(['status_id' => $status->id]);

        $this->assertEquals(2, $status->likesCount());
    }
}
