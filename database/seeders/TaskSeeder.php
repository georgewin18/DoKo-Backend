<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task')->insert([
            [
                'name' => 'Create landing page',
                'description' => 'Design and implement main page',
                'attachment' => null,
                'date' => '2025-08-15',
                'time' => '10:00:00',
                'progress' => 0,
                'task_group_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Backend API',
                'description' => 'Create Backend API',
                'attachment' => null,
                'date' => '2025-08-20',
                'time' => '14:00:00',
                'progress' => 50,
                'task_group_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Documentation',
                'description' => 'MCreate technical documentation',
                'attachment' => null,
                'date' => '2025-08-25',
                'time' => '09:00:00',
                'progress' => 0,
                'task_group_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
