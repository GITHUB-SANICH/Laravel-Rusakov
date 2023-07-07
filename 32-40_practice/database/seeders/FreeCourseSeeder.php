<?php

namespace Database\Seeders;

use App\Models\FreeCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FreeCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		FreeCourse::factory()->count(20)->create();
    }
}
