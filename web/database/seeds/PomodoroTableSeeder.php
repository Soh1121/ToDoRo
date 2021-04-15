<?php

use Illuminate\Database\Seeder;

class PomodoroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Pomodoro::create([
            'user_id' => 1,
            'date' => '2021-03-26 00:00:00',
            'count' => 1,
        ]);
        App\Pomodoro::create([
            'user_id' => 1,
            'date' => '2021-03-27 00:00:00',
            'count' => 2,
        ]);
        App\Pomodoro::create([
            'user_id' => 2,
            'date' => '2021-03-27 00:00:00',
            'count' => 3,
        ]);
    }
}
