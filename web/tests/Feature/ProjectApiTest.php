<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function should_プロジェクトを追加すると想定した構造のJSONが返ってくる()
    {
        $name = 'test';
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('project.store', [
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
    public function should_プロジェクトを追加できる()
    {
        $projects = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->get();
        $name = '今日';
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('project.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(201)
            ->assertJsonFragment([
                "user_id" => (string)$this->user->id,
                "name" => $name,
            ]);
    }

    /**
     * @test
     */
    public function should_プロジェクト名は30文字までOK()
    {
        $name = str_repeat("a", 30);
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('project.store', [
                    'user' => $this->user->id,
                ]),
                compact('name')
            );

        $response->assertStatus(201)
        ->assertJsonFragment([
            "user_id" => (string)$this->user->id,
            "name" => $name,
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
    public function should_プロジェクト一覧を取得できる()
    {
        // データの取得
        $response = $this
            ->actingAs($this->user)
            ->json('GET',
                route('project.index', [
                    'user' => $this->user->id,
                ])
            );
        $projects = Project::where('user_id',$this->user->id)
            ->orderBy(Project::CREATED_AT, 'desc')
            ->get();
        $expected_data = $projects->map(function($project) {
            return [
                'id' => $project->id,
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
        $name = 'today';
        $target_project = Project::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $project_id = $target_project->id;
        $response = $this->actingAs($this->user)
            ->json('PATCH',
                route('project.update', [
                    $this->user->id,
                ]),
                compact('project_id', 'name'));

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $target_project->user_id,
                'name' => $name,
            ]);
    }

    /**
     * @test
     */
    public function should_プロジェクト名は30文字まで変更できる()
    {
        $name = str_repeat("a", 30);        $target_project = Project::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $project_id = $target_project->id;
        $response = $this->actingAs($this->user)
            ->json('PATCH',
                route('project.update', [
                    $this->user->id,
                ]),
                compact('project_id', 'name'));

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'user_id' => $target_project->user_id,
                'name' => $name,
            ]);
    }

    /**
     * @test
     */
    public function should_プロジェクト名は31文字に変更できない()
    {
        $name = str_repeat("a", 31);
        $target_project = Project::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $project_id = $target_project->id;
        $response = $this->actingAs($this->user)
            ->json('PATCH',
                route('project.update', [
                    $this->user->id,
                ]),
                compact('project_id', 'name'));

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_プロジェクトを削除できる()
    {
        $target_project = Project::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->first();
        $project_id = $target_project->id;
        $response = $this->actingAs($this->user)
            ->json('DELETE',
                route('project.delete', [
                    $this->user->id,
                ]),
                compact('project_id')
            );
        $response->assertStatus(200)
            ->assertJsonMissing(['id' => $project_id]);
    }
}
