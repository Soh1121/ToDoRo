<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Task;

class TaskController extends Controller
{
    // 認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * タスク検索
     *
     * @param int $user_id
     * @return array
     */
    private function search($user_id)
    {
        $tasks = Task::where('user_id', $user_id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();
        $data = $tasks->map(function ($task) {
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

        return $data;
    }

    /**
     * タスク追加
     * @param int $user_id
     * @param TaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $user_id, TaskRequest $request)
    {
        $task = new Task();
        $task->user_id = $user_id;
        $task->name = $request->name;
        $task->project_id = $request->project_id;
        $task->context_id = $request->context_id;
        $task->start_date = $request->start_date;
        $task->due_date = $request->due_date;
        $task->term = $request->term;
        $task->finished = 0;    // 何ポモドーロ完了しているか
        $task->done = 0;        // 未完：0 完了：1
        $task->timer = 25 * 60; // 1ポモドーロ 25分 × 60秒で残り何秒か
        $task->repeat_id = $request->repeat_id;
        $task->priority_id = $request->priority_id;
        $task->save();

        $new_tasks = $this->search($user_id);

        // リソースの新規作成なのでレスポンスコードは201(CREATED)
        return response()->json(['data' => $new_tasks], 201);
    }

    /**
     * タスク一覧
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id)
    {
        $data = $this->search($user_id);

        return response()->json(['data' => $data]);
    }

    /** タスク変更
     * @param int $user_id
     * @param TaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $user_id, TaskRequest $request)
    {
        $task_id = $request->task_id;
        $task = Task::find($task_id);
        $task->fill($request->all())->save();
        $tasks = $this->search($user_id);
        return response()->json(['data' => $tasks], 200);
    }

    public function delete(int $user_id, TaskRequest $request)
    {
        Task::find($request->task_id)->delete();
        $tasks = $this->search($user_id);
        return response()->json(['data' => $tasks], 200);
    }
}
