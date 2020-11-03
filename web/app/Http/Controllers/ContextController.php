<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContextRequest;
use App\Context;
use Illuminate\Http\Request;

class ContextController extends Controller
{
    // 認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * コンテキスト追加
     * @param ContextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $user_id, ContextRequest $request)
    {
        $context = new Context();
        $context->user_id = $user_id;
        $context->name = $request->name;
        $context->save();

        $new_context = Context::where('id', $context->id)->first();

        // リソースの新規作成なのでレスポンスコードは201(CREATED)
        return response()->json($new_context, 201, [], JSON_NUMERIC_CHECK);
    }

    /**
     * コンテキスト一覧
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id)
    {
        return response()->json(['data' => '']);
    }
}
