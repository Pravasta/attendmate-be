<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@attendmate.com',
            'password' => 'Cobacoba123#'
        ]);
        User::factory()->create([
            'name' => 'pravasta',
            'email' => 'pravasta.fitrayana@attendmate-user.com',
            'password' => 'Cobacoba123#'
        ]);
    }
}
