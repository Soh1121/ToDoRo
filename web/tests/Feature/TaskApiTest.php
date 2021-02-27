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
        $this->seed('TaskTableSeeder');
        $this->seed('RepeatsTableSeeder');
        $this->seed('PrioritiesTableSeeder');
        $this->user = User::first();
    }

    /**
     * リレーションを解決した正解データを生成
     *
     * @param object $tasks
     * @return object
     */
    public function createCorrect(object $tasks)
    {
        $expected_data = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'user_id' => $task->user_id,
                'project_id' => $task->project_id,
                'project' => $task->project->name,
                'context_id' => $task->context_id,
                'context' => $task->context->name,
                'start_date' => $task->start_date,
                'due_date' => $task->due_date,
                'term' => $task->term,
                'finished' => $task->finished,
                'done' => $task->done,
                'timer' => $task->timer,
                'repeat_id' => $task->repeat_id,
                'repeat' => $task->repeat->name,
                'priority_id' => $task->priority_id,
                'priority' => $task->priority->name,
            ];
        })->all();

        return $expected_data;
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
        $priority_id = 3;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => $expected_data,
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
        $priority_id = 0;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
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
        $priority_id = 3;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => $expected_data,
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
        $priority_id = 0;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
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
        $priority_id = 0;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
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
        $priority_id = 0;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
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
        $priority_id = 3;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => $expected_data,
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
        $priority_id = 3;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => $expected_data,
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
        $priority_id = 0;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_priorityが0以下は追加できない()
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
        $priority_id = 0;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_priorityが1は追加できる()
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
        $priority_id = 1;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_priorityが5は追加できる()
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
        $priority_id = 5;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);
        $response->assertStatus(201)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_priorityが6以上は追加できない()
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
        $priority_id = 6;
        $response = $this->actingAs($this->user)
            ->json(
                'POST',
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
                    'priority_id'
                )
            );
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_タスク一覧を取得できる()
    {
        $response = $this
            ->actingAs($this->user)
            ->json(
                'GET',
                route('task.index', [
                    'user' => $this->user->id,
                ])
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $expected_data = $this->createCorrect($tasks);

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
    public function should_タスク名を変更できる()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = 'タスク名変更';
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 正解を設定
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->name = $name;
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_タスク名は0文字に変更でない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = '';
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_タスク名は140文字まで変更できる()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = str_repeat("r", 140);;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 正解を設定
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->name = $name;
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_タスク名は141文字では変更できない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = str_repeat("r", 141);;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_開始日が終了日よりあとには変更できない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = '2021-12-31';
        $due_date = '2020-12-31';
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_termが0未満には変更できない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = -1;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_termが0は変更できる()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = 0;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 正解を設定
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->term = (string)$term;
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_termが99は変更できる()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = 99;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 正解を設定
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->term = (string)$term;
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_termが100以上には変更できない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = 100;
        $repeat_id = $target_task->repeat_id;
        $priority_id = $target_task->priority_id;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_priorityが0以下には変更できない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = 0;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_priorityが1には変更できる()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = 1;
        $target_task->name = $name;

        // 正解を設定
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->priority_id = (string)$priority_id;
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_priorityが5には変更できる()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = 5;
        $target_task->name = $name;

        // 正解を設定
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->priority_id = (string)$priority_id;
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(200)
            ->assertJsonFragment([
                'data' => $expected_data,
            ]);
    }

    /**
     * @test
     */
    public function should_priorityが6以上には変更できない()
    {
        // 変更に必要な情報の設定
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $project_id = $target_task->project_id;
        $context_id = $target_task->context_id;
        $start_date = $target_task->start_date;
        $due_date = $target_task->due_date;
        $term = $target_task->term;
        $repeat_id = $target_task->repeat_id;
        $priority_id = 6;
        $target_task->name = $name;

        // 更新処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.update', [
                    'user' => $this->user->id,
                ]),
                compact(
                    'task_id',
                    'name',
                    'project_id',
                    'context_id',
                    'start_date',
                    'due_date',
                    'term',
                    'repeat_id',
                    'priority_id'
                )
            );

        // 処理が意図したとおりか確認
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function should_タスクを削除できる()
    {
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;
        $response = $this->actingAs($this->user)
            ->json(
                'DELETE',
                route('task.delete', [
                    $this->user->id,
                ]),
                compact(['task_id', 'name'])
            );
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        // 取得したタスク一覧に削除したはずのidが含まれていなければ良い
        foreach ($tasks as $task) {
            $this->assertNotEquals($task_id, $task->id);
        }
        $expected_data = $this->createCorrect($tasks);

        // 返ってきたデータが1個になっていて、意図したものが消えていれば良い
        $response->assertStatus(200)
            ->assertJsonStructure()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(
                ['data' => $expected_data]
            );
    }

    /**
     * @test
     */
    public function should_タスクを完了にできる()
    {
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;

        // 返却されたデータが正しいか確認するため
        $tasks = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->get();
        foreach ($tasks as $task) {
            if ($task->id === $task_id) {
                $task->finished = '1';
            }
        }
        $expected_data = $this->createCorrect($tasks);

        // 処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.finished', [
                    $this->user->id,
                ]),
                compact(['task_id', 'name'])
            );

        // データベースの値が書き換わっているか確認
        $result = Task::find($task_id);
        $this->assertEquals(1, $result->finished);

        // 返却されるデータが予想と一致しているか確認
        $response->assertStatus(200)
            ->assertJsonFragment(['data' => $expected_data]);
    }

    /**
     * @test
     */
    public function should_タスクを未完了にできる()
    {
        $target_task = Task::where('user_id', $this->user->id)
            ->orderBy('created_at', 'asc')
            ->first();
        $task_id = $target_task->id;
        $name = $target_task->name;

        // 処理を実行
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                route('task.unfinished', [
                    $this->user->id,
                ]),
                compact(['task_id', 'name'])
            );

        // 返却されるデータが予想と一致しているか確認
        $response->assertStatus(200);
    }
}
