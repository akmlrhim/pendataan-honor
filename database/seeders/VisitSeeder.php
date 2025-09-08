<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::all()->pluck('id')->toArray();

        $visits = [];

        // Buat 300 pengunjung anonim
        for ($i = 0; $i < 300; $i++) {
            $visits[] = [
                'user_id' => null,
                'ip' => $faker->ipv4,
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ];
        }

        // Buat 200 pengunjung login
        for ($i = 0; $i < 200; $i++) {
            $visits[] = [
                'user_id' => $faker->randomElement($users),
                'ip' => $faker->ipv4,
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
                'updated_at' => now(),
            ];
        }

        // Insert ke database sekaligus
        DB::table('visits')->insert($visits);
    }
}
