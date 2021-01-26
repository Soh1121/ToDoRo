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

        $new_tasks = Task::where('user_id', $user_id)
            ->orderBy(Task::CREATED_AT, 'asc')
            ->get();

        // リソースの新規作成なのでレスポンスコードは201(CREATED)
        return response()->json(['data' => $new_tasks], 201);
    }
}
