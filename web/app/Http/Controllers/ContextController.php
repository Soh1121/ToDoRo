<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
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
     * 重複するコンテキスト名があるとエラーを返す
     * フロントエンドで「未設定」の場合、編集・削除を非表示にするため、
     * 未設定を複数作られると操作できなくなる
     * @param Context $context
     * @return boolean
     */
    private static function duplicate(Context $context)
    {
        $duplicate_context = Context::where('user_id', $context->user_id)
            ->where('name', $context->name)
            ->get();
        if (count($duplicate_context) != 0) {
            return True;
        } else {
            return False;
        }
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
        if ($request->name !== '未設定') {
            $this->authorize('create', $context);
        }
        // 重複していたらエラーを返す
        if ($this->duplicate($context)) {
            return response()->json(
                [
                    'message' => 'The given data was duplicates.',
                    'errors' => [
                        'name' => ['コンテキスト名が重複しています']
                    ]
                ],
                422
            );
        }
        // 重複していなければ追加
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
        $context = Context::where('user_id', $user_id)
            ->first();
        $this->authorize('view', $context);

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
        $context_id = $request->id;
        $context = Context::find($context_id);
        $this->authorize('update', $context);
        $context->name = $request->get('name');
        // 重複していたらエラーを返す
        if ($this->duplicate($context)) {
            return response()->json(
                [
                    'message' => 'The given data was duplicates.',
                    'errors' => [
                        'name' => 'コンテキスト名が重複しています'
                    ]
                ],
                422
            );
        }
        // 重複していなければ保存
        $context->save();

        $contexts = Context::where('user_id', $user_id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->get();
        return response()->json(['data' => $contexts], 201);
    }

    /**
     * コンテキスト削除
     * @param int $user_id
     * @param ContextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $user_id, ContextRequest $request)
    {
        $context = Context::find($request->id);
        $this->authorize('delete', $context);
        $context->delete();
        $contexts = Context::where('user_id', $user_id)
            ->orderBy(Context::CREATED_AT, 'asc')
            ->get();
        return response()->json(['data' => $contexts], 200);
    }
}
