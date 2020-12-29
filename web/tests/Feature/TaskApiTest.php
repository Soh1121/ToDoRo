<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed('UserTableSeeder');
        // $this->seed('TaskTableSeeder');
        $this->user = User::first();
    }

    /**
     * @test
     */
    public function should_タスクを追加できる()
    {
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ])
            );
        $response->assertStatus(201);
    }
}
