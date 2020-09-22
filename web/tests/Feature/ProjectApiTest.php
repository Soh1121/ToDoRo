<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_プロジェクトを追加できる()
    {
        $response = $this->actingAs($this->user)
            ->json('POST', route('user.project', [
                'user' => $this->user->id,
                'project' => '今日',
            ]));

        $response->assertStatus(201)
            ->assertJsonFragment([
                "user_id" => $this->user->id,
                "name" => '今日',
            ]);
    }

    /**
     * @test
     */
    public function should_プロジェクト名は15文字までOK()
    {
        $name = str_repeat("a", 15);
        $response = $this->actingAs($this->user)
            ->json('POST', route('user.project', [
                'user' => $this->user->id,
                'project' => $name,
            ]));

            $response->assertStatus(201)
                ->assertJsonFragment([
                    "user_id" => $this->user->id,
                    "name" => $name,
                ]);
    }

    /**
     * @test
     */
    public function should_プロジェクト名は16文字はNG()
    {
        $name = str_repeat("a", 16);
        $response = $this->actingAs($this->user)
            ->json('POST', route('user.project', [
                'user' => $this->user->id,
                'project' => $name,
            ]));

            $response->assertStatus(422);
    }
}
