<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $items = Lesson::all();
        return view('admin.test', ['items' => $items]);
    }
}
