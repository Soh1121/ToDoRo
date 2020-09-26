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
    public function addProject(AddProject $request)
    {
        $project = new Project();
        $project->user_id = Auth::user()->id;
        $project->name = $request->project;

        Auth::user()->projects()->save($project);
        DB::commit();

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
     * @param int $id
     * @param AddProject $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, AddProject $request)
    {
        $project = Project::find($id);
        $project->name = $request->get('project');
        $project->save();
        return response()->json($project, 201);
    }

    /**
     * プロジェクト削除
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        Project::find($id)->delete();
        return response()->json([], 204);
    }
}