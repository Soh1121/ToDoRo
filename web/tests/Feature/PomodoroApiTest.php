<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PomodoroApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('UserTableSeeder');
        $this->seed('PomodoroTableSeeder');
        $this->user = User::first();
    }

    /**
     * @test
     */
    public function should_ポモドーロ数を新たに追加できる()
    {
        $date = '2021-03-28 00:00:00';
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
                route('pomodoro.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'date'
                )
            );

        // 新規作成のためHTTPステータスは201
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => ['count' => '1'],
            ]);
    }

    /**
     * @test
     */
    public function should_ポモドーロ数を登録済みだったらカウント数が返ってくる()
    {
        $date = '2021-03-27 08:00:00';
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
                route('pomodoro.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'date'
                )
            );

        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => ['count' => '2'],
            ]);
    }

    /**
     * @test
     */
    public function should_ポモドーロ数をインクリメントしてその日のポモドーロ数を返す()
    {
        $date = '2021-03-27 08:00:00';
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('pomodoro.increment', [
                    'user' => $this->user->id,
                ]),
                compact('date')
            );
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => ['count' => '3'],
            ]);
    }

    /**
     * @test
     */
    public function should_ポモドーロ数をインクリメントする際、未登録の日は登録した上でポモドーロ数を返す()
    {
        $date = '2021-04-23 08:00:00';
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('pomodoro.increment', [
                    'user' => $this->user->id,
                ]),
                compact('date')
            );
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => ['count' => '1'],
            ]);
    }

    /**
     * @test
     */
    public function should_ポモドーロ数が登録されていれば参照できる()
    {
        $date = '2021-03-27 00:00:00';
        $response = $this->actingAs($this->user)
            ->json(
                'GET',
                route('pomodoro.index', [
                    'user' => $this->user->id,
                    'date' => $date,
                ])
            );
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => ['count' => '2'],
            ]);
    }

    /**
     * @test
     */
    public function should_ポモドーロ数が登録されていなければ新たに登録して参照できる()
    {
        $date = '2021-04-11 00:00:00';
        $response = $this->actingAs($this->user)
            ->json(
                'GET',
                route('pomodoro.index', [
                    'user' => $this->user->id,
                    'date' => $date,
                ])
            );
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => ['count' => '0'],
            ]);
    }
}
