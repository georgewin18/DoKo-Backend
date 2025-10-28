<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FocusTimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('focus_timer')->insert([
            [
                'name' => 'Classic Pomodoro',
                'focus_time' => 25, // 25 menit
                'break_time' => 5,  // 5 menit
                'section' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Long Focus',
                'focus_time' => 50, // 50 menit
                'break_time' => 10, // 10 menit
                'section' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Study Session',
                'focus_time' => 45, // 45 menit
                'break_time' => 15, // 15 menit
                'section' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}