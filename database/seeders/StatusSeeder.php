<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Status;
use App\Models\User;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::factory()->create([
            'user_id' => 1
        ]);

        Status::factory()->create([
            'user_id' => User::all()->random()
        ]);

        Status::factory()->create([
            'user_id' => User::all()->random()
        ]);

        Status::factory()->create([
            'user_id' => User::all()->random()
        ]);

        Status::factory()->create([
            'user_id' => User::all()->random()
        ]);        
    }
}
