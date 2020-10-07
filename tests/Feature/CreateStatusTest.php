<?php

namespace Tests\Feature;

use App\Http\Resources\StatusResource;
use App\Models\User;
use App\Models\Status;
use App\Events\StatusCreated;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CreateStatusTest extends TestCase
{
    use RefreshDatabase; // Realiza las transacciones en memoria para la base de datos

    /** @test */
    public function guests_can_not_create_statuses()
    {
        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer estado']);

        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
        Event::fake([StatusCreated::class]);
        
        // 1. Given => Teniendo un usuario autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. When => Cuando hace un post request a status
        
        // Verificamos que recibimos una respuesta adecuada
        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer estado']);

        $response->assertJson([
            'data' => ['body' => 'Mi primer estado'],
        ]); // Verifica que luego de crear el estado nos devuelva un json (desde la vista en Vue)

        // 3. Then  => Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer estado'
        ]);


    }

    /** @test */
    public function an_event_is_fired_when_a_status_is_created()
    {
        Event::fake([StatusCreated::class]); //simulamos todos los eventos o solo StatusCreated mediante []

        //validamos que reciba el llamado 'socket' y retorne socket-id si es true
        Broadcast::shouldReceive('socket')->andReturn('socket-id');

        // $this->withoutExceptionHandling();  // Evita que laravel maneje las exepciones

        $user = User::factory()->create();
        
        // Verificamos que recibimos una respuesta adecuada
        $this->actingAs($user)->postJson(route('statuses.store'), ['body' => 'Mi primer estado']);

        Event::assertDispatched(StatusCreated::class, function($statusCreatedEvent){
            
            $this->assertInstanceOf(StatusResource::class, $statusCreatedEvent->status);
            
            $this->assertTrue(Status::first()->is($statusCreatedEvent->status->resource)); // Assert Instancia y Id

            $this->assertEventChannelType('public', $statusCreatedEvent);
            $this->assertEventChannelName('statuses', $statusCreatedEvent);
            $this->assertDontBroadcastToCurrentUser($statusCreatedEvent);

            return true;
        }); //verificamos que se dispare el evento y hacemos verificacion
    }

    /** @test */
    public function a_status_requires_a_body()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);
        
        $response->assertStatus(422); // 422: Entidad no procesable
        $response->assertJsonStructure([ // Verifica solo la estructura del JSON
            'message', 'errors' => ['body']
        ]);

    }

    /** @test */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'abcd']);
        
        $response->assertStatus(422); // 422: Entidad no procesable
        $response->assertJsonStructure([ // Verifica solo la estructura del JSON
            'message', 'errors' => ['body']
        ]);
    }
    
    

    
}
