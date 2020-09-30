<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ListStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_statuses()
    {
        $status1 = Status::factory()->create(['created_at' => now()->subDays(4)]); // Le resta 4 dias
        $status2 = Status::factory()->create(['created_at' => now()->subDays(3)]);
        $status3 = Status::factory()->create(['created_at' => now()->subDays(2)]);
        $status4 = Status::factory()->create(['created_at' => now()->subDays(1)]);
        
        $response = $this->getJson(route('statuses.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'meta' => ['total' => 4]
        ]);
        $response->assertJsonStructure([
            'data','links' => ['prev','next'] //Estructura que devuelve la respues de StatusResource
        ]);

        // Se afirma que el primer status creado es el último en crearse (Vienen ordenados del controller)
        $this->assertEquals(
            $status4->body,
            $response->json('data.0.body'),  // == data[0]['body'] Verifica que sea el primero de la respuesta
        );
    }

    /** @test */
    public function can_get_statuses_for_a_specific_user()
    {
        $user = User::factory()->create();

        $status1 = Status::factory()->create(['user_id' => $user, 'created_at' => now()->subDays()]);
        $status2 = Status::factory()->create(['user_id' => $user]);
      
        $otherStatus = Status::factory()->count(2)->create();
        
        $response = $this->actingAs($user)
            ->getJson(route('users.statuses.index', $user));
                
        $response->assertJson([
            'meta' => ['total' => 2]
        ]);
        $response->assertJsonStructure([
            'data','links' => ['prev','next'] //Estructura que devuelve la respues de StatusResource
        ]);

        // Se afirma que el primer status creado es el último en crearse (Vienen ordenados del controller)
        $this->assertEquals(
            $status2->body,
            $response->json('data.0.body'),  // == data[0]['body'] Verifica que sea el primero de la respuesta
        );
    }
}
