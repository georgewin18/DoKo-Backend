<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_group')->insert([
            [
                'name' => 'Project A',
                'description' => 'Tasks for Project A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Project B',
                'description' => 'Tasks for Project B',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
