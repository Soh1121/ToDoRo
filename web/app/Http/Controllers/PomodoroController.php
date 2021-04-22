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

    /**
     * ポモドーロ数を取得し、当日のポモドーロ数がなければ新規登録
     *
     * @param integer $user_id
     * @param string $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id, string $date)
    {
        $excution_date = $date;
        $excution_date = explode(' ', $excution_date)[0] . ' 00:00:00';

        // その日ポモドーロを回していなければカウント1で新規作成
        $item = Pomodoro::userIdEqual($user_id)
            ->dateEqual($excution_date)
            ->first();
        if (is_null($item)) {
            $pomodoro = new Pomodoro();
            $pomodoro->user_id = $user_id;
            $pomodoro->date = $excution_date;
            $pomodoro->count = 0;
            $pomodoro->save();
        }

        $item = Pomodoro::userIdEqual($user_id)
            ->dateEqual($excution_date)
            ->first();

        return response()->json(['data' => $item], 200);
    }

    /**
     * 当日ポモドーロ数を新規登録
     *
     * @param integer $user_id
     * @param PomodoroRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * 当日ポモドーロ数をインクリメント
     *
     * @param integer $user_id
     * @param PomodoroRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function increment(int $user_id, PomodoroRequest $request)
    {
        $excution_date = $request->date;
        $excution_date = explode(' ', $excution_date)[0] . ' 00:00:00';

        // すでにその日ポモドーロを回していたら200でcountを返す
        $item = Pomodoro::userIdEqual($user_id)
            ->dateEqual($excution_date)
            ->first();
        if (!$item) {
            $item = new Pomodoro();
            $item->user_id = $user_id;
            $item->date = $excution_date;
            $item->count = 0;
        }
        $item->count += 1;
        $item->save();


        // 保存したデータを取得
        $item = Pomodoro::userIdEqual($user_id)
            ->dateEqual($excution_date)
            ->first();

        return response()->json(['data' => $item], 200);
    }
}
