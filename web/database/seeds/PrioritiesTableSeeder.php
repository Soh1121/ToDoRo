<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '未設定',
        ];
        DB::table('priorities')->insert($param);

        $param = [
            'name' => '第1領域（緊急度高・重要度高）',
        ];
        DB::table('priorities')->insert($param);

        $param = [
            'name' => '第2領域（緊急度低・重要度高）',
        ];
        DB::table('priorities')->insert($param);

        $param = [
            'name' => '第3領域（緊急度高・重要度低）',
        ];
        DB::table('priorities')->insert($param);

        $param = [
            'name' => '第4領域（緊急度低・重要度低）',
        ];
        DB::table('priorities')->insert($param);
    }
}
