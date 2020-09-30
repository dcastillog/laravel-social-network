<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Status;
use App\Models\User;

use Illuminate\Database\Seeder;

class LikeStatusSeeder extends Seeder
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
            'likeable_id' => Status::all()->random(),
            'likeable_type' => Status::class
        ]); 
    }
}
