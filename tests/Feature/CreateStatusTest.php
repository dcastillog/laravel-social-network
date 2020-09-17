<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CreateStatusTest extends TestCase
{
    use RefreshDatabase; // Realiza las transacciones en memoria para la base de datos

    /** @test */
    public function guests_can_not_create_statuses()
    {
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer estado']);

        $response->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
        
        $this->withoutExceptionHandling();  // Evita que laravel maneje las exepciones

        // 1. Given => Teniendo un usuario autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2. When => Cuando hace un post request a status
        
        // Verificamos que recibimos una respuesta adecuada
        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer estado']);

        $response->assertJson([
            'body' => 'Mi primer estado'
        ]); // Verifica que luego de crear el estado nos devuelva un json (desde la vista en Vue)

        // 3. Then  => Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer estado'
        ]);


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
