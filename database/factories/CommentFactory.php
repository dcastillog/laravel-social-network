<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Status;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text(200),
            'user_id' => User::factory(),
            'status_id' => Status::factory(),
        ];
    }
}
