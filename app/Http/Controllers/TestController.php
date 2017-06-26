<?php

namespace App\Http\Controllers;

use App\Facades\MessageFacade;
use App\Http\Wechat\WxException;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function __construct()
    {
        $this->middleware('auth')->only('send');
    }

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
        $user = User::first();
        try {
            MessageFacade::sendWechatPreClassMessage($user, Course::first());
        } catch (WxException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
        return ['success' => true];
    }
}
