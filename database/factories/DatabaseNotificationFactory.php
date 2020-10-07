<?php

namespace Database\Factories;

use App\Models\User;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatabaseNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid()->toString(),
            'type' => 'App\\Notifications\\ExampleNotification',
            'notifiable_id' => User::factory(),
            'notifiable_type' => 'App\\User',
            'data' => [
                'link' => url('/'),
                'message' => 'Message'
            ],
            'read_at' => null,
        ];
    }
}
