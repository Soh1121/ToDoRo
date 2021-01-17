<?php

namespace App\Http\Controllers;

use App\Repeat;

class RepeatController extends Controller
{
    /**
     * 繰り返し一覧
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $repeats = Repeat::get();

        return response()->json(['data' => $repeats]);
    }
}
