<?php

namespace Database\Seeders;

use App\Pomodoro;
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
        Pomodoro::create([
            'user_id' => 1,
            'date' => '2021-03-26 00:00:00',
            'count' => 1,
        ]);
        Pomodoro::create([
            'user_id' => 1,
            'date' => '2021-03-27 00:00:00',
            'count' => 2,
        ]);
        Pomodoro::create([
            'user_id' => 2,
            'date' => '2021-03-27 00:00:00',
            'count' => 3,
        ]);
    }
}
