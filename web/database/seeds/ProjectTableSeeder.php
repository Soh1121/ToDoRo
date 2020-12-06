<?php

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
        App\Project::create([
            'user_id' => 1,
            'name' => '今日1',
        ]);
        App\Project::create([
            'user_id' => 1,
            'name' => '明日1',
        ]);
        App\Project::create([
            'user_id' => 2,
            'name' => '今日2',
        ]);
        App\Project::create([
            'user_id' => 2,
            'name' => '明日2',
        ]);
    }
}
