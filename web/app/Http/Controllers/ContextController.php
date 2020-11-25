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
     * @param int $user_id
     * @param ContextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $user_id, ContextRequest $request)
    {
        $context = new Context();
        $context->user_id = $user_id;
        $context->name = $request->name;
        $context->save();

        $new_context = Context::where('user_id', $user_id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->get();

        // リソースの新規作成なのでレスポンスコードは201(CREATED)
        // return response()->json(['data' => $new_context], 201, [], JSON_NUMERIC_CHECK);
        return response()->json(['data' => $new_context], 201);
    }

    /**
     * コンテキスト一覧
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id)
    {
        $contexts = Context::where('user_id', $user_id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->get();

        return response()->json(['data' => $contexts]);
    }

    /**
     * コンテキスト名変更
     * @param int $user_id
     * @param ContextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $user_id, ContextRequest $request)
    {
        $context_id = $request->context_id;
        $context = Context::find($context_id);
        $context->name = $request->get('name');
        $context->save();

        $contexts = Context::where('user_id', $user_id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->get();
        return response()->json($contexts, 201);
    }

    /**
     * コンテキスト削除
     * @param int $user_id
     * @param ContextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $user_id, ContextRequest $request)
    {
        Context::find($request->context_id)->delete();
        $contexts = Context::where('user_id', $user_id)->get();
        return response()->json($contexts, 200);
    }
}
