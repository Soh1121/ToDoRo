<?php

namespace App\Http\Controllers;

use App\Http\Requests\PomodoroRequest;
use App\Pomodoro;

class PomodoroController extends Controller
{
    // 認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(int $user_id, PomodoroRequest $request)
    {
        return response()->json(['data' => ''], 201);
    }
}
