<?php

use Illuminate\Database\Seeder;

class ContextTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Context::create([
            'user_id' => 1,
            'name' => 'A_早朝（4:00-6:00）',
        ]);
        App\Context::create([
            'user_id' => 1,
            'name' => 'B_出勤時間帯（6:00-8:00）',
        ]);
        App\Context::create([
            'user_id' => 2,
            'name' => 'C_朝（8:00-10:00）',
        ]);
        App\Context::create([
            'user_id' => 2,
            'name' => 'D_午前中（10:00-12:00）',
        ]);
        App\Context::create([
            'user_id' => 2,
            'name' => 'E_昼（12:00-14:00）',
        ]);
        App\Context::create([
            'user_id' => 3,
            'name' => 'F_午後（14:00-16:00）',
        ]);
        App\Context::create([
            'user_id' => 3,
            'name' => 'G_夕方（16:00-18:00）',
        ]);
        App\Context::create([
            'user_id' => 3,
            'name' => 'H_帰宅中（18:00-20:00）',
        ]);
        App\Context::create([
            'user_id' => 3,
            'name' => 'I_夜（20:00-22:00）',
        ]);
    }
}
