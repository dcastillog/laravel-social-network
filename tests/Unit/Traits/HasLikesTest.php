<?php

namespace Tests\Unit\Traits;

use App\Models\Like;
use App\Models\User;

use App\Traits\HasLikes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasLikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_model_morph_many_likes()
    {
        $model = new ModelWithLikes(['id' => 1]);

        Like::factory()->create([
            'likeable_id' => $model->id,          // 1
            'likeable_type' => get_class($model)  // App\\Models\\Comment;
        ]);

        $this->assertInstanceOf(Like::class, $model->likes->first());
    }

    /** @test */
    public function a_model_can_be_liked_and_unlike()
    {
        $model = new ModelWithLikes(['id' => 1]);

        $this->actingAs(User::factory()->create());
        
        $model->like();

        $this->assertEquals(1, $model->likes()->count()); // Verifica que el estado tenga un likee

        $model->unlike();

        $this->assertEquals(0, $model->likes()->count()); 
    }

    /** @test */
    public function a_model_can_be_liked_once()
    {
        $model = new ModelWithLikes(['id' => 1]);

        $this->actingAs(User::factory()->create());
        
        $model->like();
        $this->assertEquals(1, $model->likes->count()); 

        $model->like();
        $this->assertEquals(1, $model->likes()->count());
    }

    /** @test */
    public function a_model_knows_if_has_been_liked_and_unliked()
    {
        $model = new ModelWithLikes(['id' => 1]);

        $this->assertFalse($model->isLiked());
        
        $this->actingAs(User::factory()->create());
        
        $this->assertFalse($model->isLiked());

        $model->like();

        $this->assertTrue($model->isLiked());
    }

    /** @test */
    public function a_model_knows_how_many_likes_it_has()
    {
        $model = new ModelWithLikes(['id' => 1]);

        $this->assertEquals(0, $model->likesCount());

        Like::factory()->count(2)->create([
            'likeable_id' => $model->id,          // 1
            'likeable_type' => get_class($model)  // App\\Models\\Status;
        ]);

        $this->assertEquals(2, $model->likesCount());
    }
}

// Modelo de prueba para probar HasLikes

class ModelWithLikes extends Model
{
    use HasLikes;

    protected $fillable = ['id'];   
}

