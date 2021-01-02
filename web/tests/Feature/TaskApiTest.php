<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use App\Context;
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
        $this->seed('ProjectTableSeeder');
        $this->seed('ContextTableSeeder');
        // $this->seed('TaskTableSeeder');
        $this->user = User::first();
    }

    /**
     * @test
     */
    public function should_タスクを追加できる()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 3;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $name,
                'user_id' => (string)$this->user->id,
                'project_id' => (string)$project->id,
                'context_id' => (string)$context->id,
                'start_date' => $start_date,
                'due_date' => $due_date,
                'term' => (string)$term,
                'finished' => '0',
                'done' => '0',
                'timer' => (string)(25 * 60),
                'repeat_id' => (string)$repeat_id,
                'priority' => (string)$priority
            ]);
    }

    /**
     * @test
     */
    public function should_タスク名は0文字は追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = "";
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_タスク名は140文字まで追加できる()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = str_repeat("r", 140);
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $name,
                'user_id' => (string)$this->user->id,
                'project_id' => (string)$project->id,
                'context_id' => (string)$context->id,
                'start_date' => $start_date,
                'due_date' => $due_date,
                'term' => (string)$term,
                'finished' => '0',
                'done' => '0',
                'timer' => (string)(25 * 60),
                'repeat_id' => (string)$repeat_id,
                'priority' => (string)$priority
            ]);
    }

    /**
     * @test
     */
    public function should_タスク名は141文字は追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = str_repeat('a', 141);
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_開始日が終了日よりあとでは追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2021-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_終了日が開始日より先では追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2019-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_termが0未満は追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = -1;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_termが0は追加できる()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 0;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $name,
                'user_id' => (string)$this->user->id,
                'project_id' => (string)$project->id,
                'context_id' => (string)$context->id,
                'start_date' => $start_date,
                'due_date' => $due_date,
                'term' => (string)$term,
                'finished' => '0',
                'done' => '0',
                'timer' => (string)(25 * 60),
                'repeat_id' => (string)$repeat_id,
                'priority' => (string)$priority
            ]);
    }

    /**
     * @test
     */
    public function should_termが99は追加できる()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 99;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $name,
                'user_id' => (string)$this->user->id,
                'project_id' => (string)$project->id,
                'context_id' => (string)$context->id,
                'start_date' => $start_date,
                'due_date' => $due_date,
                'term' => (string)$term,
                'finished' => '0',
                'done' => '0',
                'timer' => (string)(25 * 60),
                'repeat_id' => (string)$repeat_id,
                'priority' => (string)$priority
            ]);
    }

    /**
     * @test
     */
    public function should_termが100以上は追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 100;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_priorityが0未満は追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = -1;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_priorityが0は追加できる()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 0;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
            $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $name,
                'user_id' => (string)$this->user->id,
                'project_id' => (string)$project->id,
                'context_id' => (string)$context->id,
                'start_date' => $start_date,
                'due_date' => $due_date,
                'term' => (string)$term,
                'finished' => '0',
                'done' => '0',
                'timer' => (string)(25 * 60),
                'repeat_id' => (string)$repeat_id,
                'priority' => (string)$priority
            ]);
    }

    /**
     * @test
     */
    public function should_priorityが4は追加できる()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 4;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
            $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => $name,
                'user_id' => (string)$this->user->id,
                'project_id' => (string)$project->id,
                'context_id' => (string)$context->id,
                'start_date' => $start_date,
                'due_date' => $due_date,
                'term' => (string)$term,
                'finished' => '0',
                'done' => '0',
                'timer' => (string)(25 * 60),
                'repeat_id' => (string)$repeat_id,
                'priority' => (string)$priority
            ]);
    }

    /**
     * @test
     */
    public function should_priorityが5以上は追加できない()
    {
        $project = Project::where('user_id', $this->user->id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->first();
        $context = Context::where('user_id', $this->user->id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->first();
        $name = 'テスト';
        $project_id = $project->id;
        $context_id = $context->id;
        $start_date = '2020-12-31';
        $due_date = '2020-12-31';
        $term = 5;
        $repeat_id = 1;
        $priority = 5;
        $response = $this->actingAs($this->user)
            ->json('POST',
                route('task.store', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority'
                )
            );
        $response->assertStatus(422);
    }
}
