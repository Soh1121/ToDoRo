<?php

namespace App\Http\Controllers;

use App\Repeat;

class PriorityController extends Controller
{
    /**
     * 優先度一覧
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['data' => '']);
    }
}
