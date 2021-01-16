<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザーの確認
Route::get('/user', function(){ return Auth::user(); })->name('user');

// 繰り返し一覧
Route::get('/repeat', 'RepeatController@index')->name('repeat');

// プロジェクト追加
Route::post('/projects/{user}', 'ProjectController@store')->name('project.store');

// プロジェクト一覧
Route::get('/projects/{user}', 'ProjectController@index')->name('project.index');

// プロジェクト名編集
Route::patch('/projects/{user}', 'ProjectController@update')->name('project.update');

// プロジェクト削除
Route::delete('/projects/{user}', 'ProjectController@delete')->name('project.delete');

// コンテキスト追加
Route::post('/contexts/{user}', 'ContextController@store')->name('context.store');

// コンテキスト一覧
Route::get('/contexts/{user}', 'ContextController@index')->name('context.index');

// コンテキスト名編集
Route::patch('/contexts/{user}', 'ContextController@update')->name('context.update');

// コンテキスト削除
Route::delete('/contexts/{user}', 'ContextController@delete')->name('context.delete');

// タスク追加
Route::post('/tasks/{user}', 'TaskController@store')->name('task.store');
