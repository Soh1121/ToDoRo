<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function todo()
    {
        return view('spa/todo');
    }
}
