<?php

namespace App\Http\Controllers;

use App\Priority;

class PriorityController extends Controller
{
    /**
     * 優先度一覧
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $priorities = Priority::get();

        return response()->json(['data' => $priorities]);
    }
}
