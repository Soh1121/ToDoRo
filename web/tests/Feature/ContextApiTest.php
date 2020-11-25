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
    public function should_コンテキストを追加すると想定した構造のJSONが返ってくる()
    {
        $name = 'test';
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('context.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'name',
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function should_コンテキストを追加できる()
    {
        $contexts = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->get();
        $name = 'X_深夜（22:00-24:00）';
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('context.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => (string)$this->user->id,
                'name' => $name,
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
                'user_id' => (string)$this->user->id,
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
            ->orderBy(Context::CREATED_AT, 'asc')
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

    /**
     * @test
     */
    public function should_コンテキスト名を変更できる()
    {
        $name = 'J_深夜（22:00-24:00）';
        $target_context = Context::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $context_id = $target_context->id;
        $response = $this->actingAs($this->user)
            ->json('PATCH',
                route('context.update', [
                    $this->user->id,
                ]),
                compact('name', 'context_id')
            );

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $target_context->user_id,
                'name' => $name,
            ]);
    }

    /**
     * @test
     */
    public function should_コンテキスト名は30文字まで変更できる()
    {
        $name = str_repeat("a", 30);
        $target_context = Context::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $context_id = $target_context->id;
        $response = $this->actingAs($this->user)
            ->json('PATCH',
                route('context.update', [
                    $this->user->id,
                ]),
                compact('name', 'context_id')
            );

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $target_context->user_id,
                'name' => $name,
            ]);
    }

    /**
     * @test
     */
    public function should_コンテキスト名は31文字に変更できない()
    {
        $name = str_repeat("a", 31);
        $target_context = Context::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $context_id = $target_context->id;
        $response = $this->actingAs($this->user)
            ->json('PATCH',
                route('context.update', [
                    $this->user->id,
                ]),
                compact('name', 'context_id')
            );

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_コンテキストを削除できる()
    {
        $target_context = Context::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $context_id = $target_context->id;
        $response = $this->actingAs($this->user)
            ->json('DELETE',
                route('context.delete', [
                    $this->user->id,
                ]),
                compact('context_id')
            );
        $response->assertStatus(200)
            ->assertJsonMissing(['id' => $context_id]);
    }
}
