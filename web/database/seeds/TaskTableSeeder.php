<?php

use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'name' => 'テスト1',
            'project_id' => 1,
            'context_id' => 1,
            'start_date' => '2021-01-26 00:00:00',
            'due_date' => '2021-01-27 00:00:00',
            'term' => 5,
            'finished' => 0,
            'done' => 0,
            'timer' => 1500,
            'repeat_id' => 2,
            'priority_id' => 5,
        ];
        App\Task::create($param);
        $param['name'] = 'テスト2';
        App\Task::create($param);
    }
}
