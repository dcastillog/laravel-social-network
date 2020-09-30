<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Database\Seeder;

class LikeCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Like::factory()->create([
            'user_id' => User::all()->random(),
            'likeable_id' => Comment::all()->random(),
            'likeable_type' => Comment::class
        ]);  
    }
}
