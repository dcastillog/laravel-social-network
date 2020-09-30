<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\StatusResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Models\Status;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_status_resources_must_have_the_necesary_fields()
    {
        $status = Status::factory()->create();

        Comment::factory()->create(['status_id' => $status->id]);

        $statusResource = StatusResource::make($status)->resolve(); 

        $this->assertEquals(
            $status->id, 
            $statusResource['id']
        );
        
        $this->assertEquals(
            $status->body, 
            $statusResource['body']
        );
        
        $this->assertEquals(
            $status->created_at->diffForHumans(), 
            $statusResource['ago']
        );    
        
        $this->assertEquals(
            false, 
            $statusResource['is_liked']
        ); 
        $this->assertEquals(
            0, 
            $statusResource['likes_count']
        );

        
        
        $this->assertEquals( //Verifica el que devuelva un CommentResource
            CommentResource::class,
            $statusResource['comments']->collects
        );

        

        $this->assertInstanceOf( 
            Comment::class, //verificamos que recibimos una instancia del modelo Comment
            $statusResource['comments']->first()->resource //cuando obtenemos el primer elemento de StatusResource['comments']
        );

        $this->assertInstanceOf( //en este caso no aplica collects, dado que existe solo un usuario asociado
            UserResource::class,
            $statusResource['user']
        );

        //verificamos los parámetros que recibe (no es una colección) UserResource
        $this->assertInstanceOf(
            User::class,
            $statusResource['user']->resource
        );
    }
}
