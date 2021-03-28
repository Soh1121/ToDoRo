<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PomodoroController extends Controller
{
    // 認証
    public function __construct()
    {
        $this->middleware('auth');
    }
}
