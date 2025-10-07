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
        // User::factory(30)->create();

        User::factory()->create([
            'nama_lengkap' => 'Umum',
            'email' => 'umum@gmail.com',
            'nip' => fake()->randomNumber(9),
            'role' => 'umum'
        ]);
    }
}
