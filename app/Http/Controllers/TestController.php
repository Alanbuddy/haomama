<?php

namespace App\Http\Controllers;

use App\Facades\MessageFacade;
use App\Http\Util\BaiduMap;
use App\Http\Wechat\WxException;
use App\Jobs\SendWechatMessage;
use App\Jobs\TecentVodUpload;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use BaiduMap;

    function __construct()
    {
        $this->middleware('auth')->only('send');
    }

    public function index(Request $request)
    {
        $method = $request->get('m', 'lessons');
        if ($method) {
            $result = call_user_func([$this, $method], $request);
//            $result = $this->{$method}();
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

    public function qsend()
    {
        $job = (new SendWechatMessage(auth()->user(), Course::first()))->onQueue('wechat');
        $this->dispatch($job);
        return 'successfully dispatched a SendWechatMessage job';
    }

    public function vodUpload()
    {
        $filePath = '/home/gao/Downloads/purple.mp4';
        $item = new Video();
        $item->size = filesize($filePath);
        $item->video_type = 'common';
        auth()->user()->videos()->save($item);
        $this->dispatch((new TecentVodUpload($filePath, $item))->onQueue('wechat'));
        return 'success';
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->move(storage_path('app/video'));
        return ['success' => true];
    }
}
