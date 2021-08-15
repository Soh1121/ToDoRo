<?php

namespace Database\Seeders;

use App\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'user_id' => 1,
            'name' => '今日1',
        ]);
        Project::create([
            'user_id' => 1,
            'name' => '明日1',
        ]);
        Project::create([
            'user_id' => 2,
            'name' => '今日2',
        ]);
        Project::create([
            'user_id' => 2,
            'name' => '明日2',
        ]);
    }
}
