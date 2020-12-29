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
        return response()->json(['data' => ''], 201);
    }
}
