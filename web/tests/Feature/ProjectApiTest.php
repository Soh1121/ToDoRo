<?php

namespace Tests\Feature;

use Log;

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

        // $this->user = factory(User::class)->create();
        $this->seed('UserTableSeeder');
        $this->seed('ProjectTableSeeder');
        $this->user = User::first();
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

    /**
     * @test
     */
    public function should_プロジェクト一覧を取得できる()
    {
        // データの取得
        $response = $this
            ->actingAs($this->user)
            ->json('GET', route('project.index', ['user' => $this->user->id]));
        $projects = Project::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->get();
        $expected_data = $projects->map(function($project) {
            return [
                'user_id' => $project->user_id,
                'name' => $project->name,
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
    public function should_プロジェクト名を変更できる()
    {
        $project = 'today';
        $target_project = Project::where('user_id', $this->user->id)->orderBy('created_at', 'desc')->first();
        $response = $this
            ->actingAs($this->user)
            ->json('PATCH', route('project.edit', [$target_project->id,]), compact('project'));

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $target_project->user_id,
                'name' => $project,
            ]);
    }
}
