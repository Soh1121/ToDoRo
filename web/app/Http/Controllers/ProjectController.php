<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProject;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * プロジェクト追加
     * @param AddProject $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $user_id, AddProject $request)
    {
        $project = new Project();
        $project->user_id = $user_id;
        $project->name = $request->name;
        $project->save();

        $new_project = Project::where('id', $project->id)->first();

        // リソースの新規作成なのでレスポンスコードは201(CREATED)
        return response()->json($new_project, 201, [], JSON_NUMERIC_CHECK);
    }

    /**
     * プロジェクト一覧
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $user_id)
    {
        $projects = Project::where('user_id', $user_id)
            ->orderBy(Project::CREATED_AT, 'desc')
            ->get();

        return response()->json(['data' => $projects]);
    }

    /**
     * プロジェクト名変更
     * @param int $user_id
     * @param AddProject $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $user_id, AddProject $request)
    {
        $project_id = $request->target;
        $project = Project::find($project_id);
        $project->name = $request->get('name');
        $project->save();
        return response()->json($project, 201);
    }

    /**
     * プロジェクト削除
     * @param int $user_id
     * @param AddProject $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $user_id, AddProject $request)
    {
        Project::find($request->target)->delete();
        $projects = Project::where('user_id', $user_id)->get();
        return response()->json($projects, 200);
    }
}
