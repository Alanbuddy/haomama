<?php

namespace App\Http\Controllers;

use App\Facades\MessageFacade;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        MessageFacade::sendWechatPreClassMessage(auth()->user(),Course::first());
        $items = Lesson::all();
        return view('admin.test', ['items' => $items]);
    }
}
