<?php

namespace Tests\Feature;

use App\Models\Status;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ListStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_statuses()
    {
        $this->withoutExceptionHandling();

        $status1 = Status::factory()->create(['created_at' => now()->subDays(4)]); // Le resta 4 dias
        $status2 = Status::factory()->create(['created_at' => now()->subDays(3)]);
        $status3 = Status::factory()->create(['created_at' => now()->subDays(2)]);
        $status4 = Status::factory()->create(['created_at' => now()->subDays(1)]);
        
        $response = $this->getJson(route('statuses.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'total' => 4
        ]);
        $response->assertJsonStructure([
            'data','total','first_page_url','last_page_url'
        ]);

        // Se afirma que el primer status creado es el último en crearse (Vienen ordenados del controller)
        $this->assertEquals(
            $status4->id,
            $response->json('data.0.id'),  // == data[0]['id']
        );
    }
}
