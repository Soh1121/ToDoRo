<?php

namespace Tests\Feature;

use App\Context;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContextApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // $this->user = factory(User::class)->create();
        $this->seed('UserTableSeeder');
        $this->seed('ContextTableSeeder');
        $this->user = User::first();
    }

    /**
     * @test
     */
    public function should_コンテキストを追加できる()
    {
        $name = 'A_早朝（4:00-6:00）';
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('context.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(201)
            ->assertJsonFragment([
                "user_id" => $this->user->id,
                "name" => 'A_早朝（4:00-6:00）',
            ]);
    }

    /**
     * @test
     */
    public function should_コンテキスト名は30文字までOK()
    {
        $name = str_repeat("a", 30);
        $response = $this
            ->actingAs($this->user)
            ->json('POST',
                route('context.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $this->user->id,
                'name' => $name,
            ]);
    }

    /**
     * @test
     */
    public function should_プロジェクト名は31文字はNG()
    {
        $name = str_repeat("a", 31);
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('project.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_コンテキスト一覧を取得できる()
    {
        // データの取得
        $response = $this
            ->actingAs($this->user)
            ->json('GET',
                route('context.index', [
                    'user' => $this->user->id,
                ])
            );
        $contexts = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'desc')
            ->get();
        $expected_data = $contexts->map(function($context) {
            return [
                'id' => $context->id,
                'user_id' => $context->user_id,
                'name' => $context->name,
            ];
        })->all();

        $response->assertStatus(200)
            ->assertJsonStructure()
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }
}
