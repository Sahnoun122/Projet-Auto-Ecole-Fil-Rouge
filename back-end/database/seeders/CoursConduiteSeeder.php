<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursConduite;

class CoursConduiteSeeder extends Seeder
{
    public function run()
    {
        CoursConduite::factory()->count(10)->create();
    }
}
