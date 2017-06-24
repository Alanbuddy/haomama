<?php

namespace App\Http\Controllers;

use App\Facades\MessageFacade;
use App\Http\Wechat\WxException;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $method = $request->get('m', 'lessons');
        if ($method) {
            $result = call_user_func([$this, $method], $request);
            dd($result);
        }
        return 'no method found';
    }

    public function lessons()
    {
        $items = Lesson::all();
        return ($items);
    }

    public function send()
    {
        try {
            MessageFacade::sendWechatPreClassMessage(auth()->user(), Course::first());
        } catch (WxException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
        return ['success' => true];
    }
}
