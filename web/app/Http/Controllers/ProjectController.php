<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Project;

class ProjectController extends Controller
{
    // 認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 重複するプロジェクト名があるとエラーを返す
     * フロントエンドで「未設定」の場合、編集・削除を非表示にするため、
     * 未設定を複数作られると操作できなくなるのを防ぐため
     * @param Project $project
     * @return boolean
     */
    private static function duplicate(Project $project)
    {
        $duplicate_project = Project::where('user_id', $project->user_id)
            ->where('name', $project->name)
            ->get();
        if (count($duplicate_project) != 0) {
            return True;
        } else {
            return False;
        }
    }

    /**
     * プロジェクト追加
     * @param int $user_id
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $user_id, ProjectRequest $request)
    {
        $project = new Project();
        $project->user_id = $user_id;
        $project->name = $request->name;
        // 重複していたらエラーを返す
        if ($this->duplicate($project)) {
            return response()->json(
                [
                    'message' => 'The given data was duplicates.',
                    'errors' => [
                        'name' => ['プロジェクト名が重複しています']
                    ]
                    ], 422
            );
        }
        // 重複していなければ追加
        $project->save();

        $new_project = Project::where('user_id', $user_id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->get();

        // リソースの新規作成なのでレスポンスコードは201(CREATED)
        return response()->json(['data' => $new_project], 201);
    }

    /**
     * プロジェクト一覧
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id)
    {
        $projects = Project::where('user_id', $user_id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->get();

        return response()->json(['data' => $projects]);
    }

    /**
     * プロジェクト名変更
     * @param int $user_id
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $user_id, ProjectRequest $request)
    {
        $project_id = $request->project_id;
        $project = Project::find($project_id);
        $project->name = $request->get('name');
        $project->save();

        $projects = Project::where('user_id', $user_id)
            ->orderBy(Project::CREATED_AT, 'asc')
            ->get();
        return response()->json(['data' => $projects], 201);
    }

    /**
     * プロジェクト削除
     * @param int $user_id
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $user_id, ProjectRequest $request)
    {
        Project::find($request->project_id)->delete();
        $projects = Project::where('user_id', $user_id)->get();
        return response()->json(['data' => $projects], 200);
    }
}
