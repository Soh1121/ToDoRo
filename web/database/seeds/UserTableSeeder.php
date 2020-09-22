<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'taro',
            'email' => 'taro@example.com',
            'password' => Hash::make('hogehoge'),
        ]);
        App\User::create([
            'name' => 'hanako',
            'email' => 'hanako@example.com',
            'password' => Hash::make('hogehoge'),
        ]);
    }
}
