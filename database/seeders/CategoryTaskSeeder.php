<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('category_tasks')->insert([
            [
                'category_id' => 4,
                'name' => 'Build login page',
                'description' => 'Implement UI and backend for login',
                'status' => 'pending',
                'date_from' => now()->subDays(2),
                'date_to' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 2,
            ],
            [
                'category_id' => 5,
                'name' => 'Design landing page',
                'description' => 'Create wireframes and UI mockups',
                'status' => 'in-progress',
                'date_from' => now(),
                'date_to' => now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 2,
            ],
            [
                'category_id' => 6,
                'name' => 'Build login page',
                'description' => 'Implement UI and backend for login',
                'status' => 'pending',
                'date_from' => now()->subDays(2),
                'date_to' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 22,
            ],
            [
                'category_id' => 6,
                'name' => 'Design landing page',
                'description' => 'Create wireframes and UI mockups',
                'status' => 'in-progress',
                'date_from' => now(),
                'date_to' => now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 22,
            ],
        ]);
    }
}
