<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'uuid' => Str::uuid(),
            'key' => 'batas_honor',
            'value' => '3300000'
        ]);

        Settings::create([
            'uuid' => Str::uuid(),
            'key' => 'pejabat_pembuat_komitmen',
            'value' => 'Warkani, SE.'
        ]);

        Settings::create([
            'uuid' => Str::uuid(),
            'key' => 'kepala_bps_tapin',
            'value' => 'Rudy Nooryadi, S.Si., ME.'
        ]);
    }
}
