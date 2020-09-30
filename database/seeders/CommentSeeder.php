<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Status;

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()->count(2)->create([
            'user_id' => User::all()->random(),
            'status_id' => Status::all()->random()
        ]);

        Comment::factory()->count(2)->create([
            'user_id' => User::all()->random(),
            'status_id' => Status::all()->random()
        ]);

        Comment::factory()->count(2)->create([
            'user_id' => User::all()->random(),
            'status_id' => Status::all()->random()
        ]);

        Comment::factory()->count(2)->create([
            'user_id' => User::all()->random(),
            'status_id' => Status::all()->random()
        ]);
    }
}
