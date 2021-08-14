<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'taro',
            'email' => 'taro@example.com',
            'password' => Hash::make('hoge1234!'),
        ]);
        User::create([
            'name' => 'hanako',
            'email' => 'hanako@example.com',
            'password' => Hash::make('hoge1234!'),
        ]);
        User::create([
            'name' => 'hiroshi',
            'email' => 'hiroshi@example.com',
            'password' => Hash::make('hoge1234!'),
        ]);
    }
}
