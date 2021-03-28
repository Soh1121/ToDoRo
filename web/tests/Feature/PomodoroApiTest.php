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
        $response->assertStatus(201);
    }
}
