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
        $excution_date = $request->date;
        $excution_date = explode(' ', $excution_date)[0] . ' 00:00:00';

        // すでにその日ポモドーロを回していたら200でcountを返す
        $item = Pomodoro::userIdEqual($user_id)
            ->dateEqual($excution_date)
            ->first();
        if (!is_null($item)) {
            return response()->json(['data' => $item], 200);
        }

        $pomodoro = new Pomodoro();
        $pomodoro->user_id = $user_id;
        $pomodoro->date = $excution_date;
        $pomodoro->count = 1;
        $pomodoro->save();

        $item = Pomodoro::userIdEqual($user_id)
            ->dateEqual($excution_date)
            ->first();

        return response()->json(['data' => $item], 201);
    }
}
