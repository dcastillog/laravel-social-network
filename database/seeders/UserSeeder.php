<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::factory()->create([
            'id' => 1,
            'name' => 'admin',
            'first_name' => 'Administrador',
            'email' => 'admin@laranet.com'
        ]);
        
        User::factory()->count(20)->create();
    }
}
