<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common;
use App\Http\Controllers\Util\IO;
use App\Models\File;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Lib\Vod\VodApi;
use App\Http\Controllers\Util\Parse;

class VideoController extends Controller
{
    use Parse;
    use IO;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Video::where('mime', 'like', 'video%')->paginate(10);
        return view('admin.video.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->type == 'compound') {
            return $this->storeCompound($request);
        }
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('video')) {
            $file = $request->file('video');
//            $fileName = $file->move(storage_path('app/video'), $file->getClientOriginalName())->getPathname();
            $fileName = $file->move(storage_path('app/video'));
            //return $file; var/www/baby.com/storage/app/video/phpMRDcqc
        } else {
            return back()->withErrors('no file selected');
        }

        ob_start();
        //上传视频文件到腾讯云
        list($vod, $ret) = $this->callVodUploadApi($fileName);
        $log = ob_get_contents();
        Log::info($log);
        ob_end_clean();
        if ($ret !== 0) {
            return back()->withErrors('error');
        } else {
            $item = new Video();
            $item->cloud_file_id = $vod->getFileId();
            $item->fill($this->getFileBaseInfo($file));
            $item->video_type = 'common';
            auth()->user()->videos()->save($item);

            list($ret, $response) = $this->callCloudTranscodeApi($item);
            Log::info(__FILE__ . "\n转码结果：" . $ret);
            Log::info(__FILE__ . "\n" . json_encode($response) . __FILE__);
            if ($ret == 0) {
                $item->video_status = 'transcoding';
                $item->save();
            }

            if ($request->ajax()) {
                return ['success' => true];
            }
            return redirect()->route('videos.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('admin.video.show', [
            'item' => $video,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Video $video
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Video $video)
    {
        $view = $video->video_type == 'common' ? 'admin.video.edit' : 'admin.video.editCompound';
        $data = ['item' => $video];
        if ($video->video_type == 'compound') {
            $pictures = $video->attachments()
                ->where('mime', 'like', 'image%')
                ->get();
            $pictures = $video->pictures()
                ->orderBy('no')
                ->get();
            $audio = $video->attachments()
                ->where('mime', 'like', 'audio%')
                ->first();
            $data = array_merge($data, [
                'pictures' => $pictures,
                'audio' => $audio,
            ]);
        }
        return view($view, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Video $video)
    {
        if ($request->has('name')) {
            $video->file_name = $request->name;
            $video->save();
        }
        if ($request->file('picture')) {
            $folderPath = public_path('storage/video/' . $video->id);
            $item = $this->moveAndStore($request, 'picture', $folderPath);
            $video->attachments()->attach($item->id);
        }
        if ($request->file('audio')) {
            $folderPath = public_path('storage/video/' . $video->id);
            $item = $this->moveAndStore($request, 'audio', $folderPath);
            $video->attachments()->attach($item->id);
        }
        if ($request->file('timeline')) {
            $file = $request->file('timeline');
            $ret = $this->parseTimeline(file_get_contents($file));
            $video->caption = json_encode($ret);
            $video->save();
        }

        return redirect()->route('videos.edit', $video);
    }

    /**
     * Remove the specified resource from storage.
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        if ($video->video_type == 'common') {//如果是腾讯云上存储的视频文件，调用腾讯云提供的API来删除云上的视频
            $vod = new VodApi();
            $vod->Init(config('services.vod.secretId'), config('services.vod.secretKey'), VodApi::USAGE_VOD_REST_API_CALL, "gz");
            $arguments = array(
                'Action' => 'DeleteVodFile',
                'fileId' => $video->cloud_file_id,
                'contentLen' => 0,
                'priority' => 0
            );
            ob_start();
            $ret = $vod->CallRestApi($arguments);
            $log = ob_get_contents();
            Log::info($log);
            ob_end_clean();
            if ($ret != 0) {
                return 'error';
            }
        } else {
            Storage::delete($video->path);
        }
        return redirect()->route('videos.index');
    }

    /**
     * 调用腾讯云接口上传视频
     * @param $fileName
     * @return array
     */
    public function callVodUploadApi($fileName)
    {
        $vod = new VodApi();
        $vod->Init(config('services.vod.secretId'), config('services.vod.secretKey'), VodApi::USAGE_UPLOAD, "gz");

        $vod->SetConcurrentNum(10);    //设置并发上传的分片数目，不调用此函数时默认并发上传数为6
        $vod->SetRetryTimes(10);    //设置每个分片可重传的次数，不调用此函数时默认值为5

// $package: 上传的文件配置参数
        $package = array(
//            'fileName' => $argv[1],                //文件的绝对路径，包含文件名
            'fileName' => $fileName,
            'dataSize' => 1024 * 1024,            //分片大小，单位Bytes。断点续传时，dataSize强制使用第一次上传时的值。
            'isTranscode' => 0,                    //是否转码
            'isScreenshot' => 1,                //是否截图
            'isWatermark' => 0,                    //是否添加水印
            'classId' => 0                        //分类
        );

        $vod->AddFileTag("测试1");
        $vod->AddFileTag("测试2");
        $ret = $vod->UploadVideo($package);
        return array($vod, $ret);
    }

    //创建类似PPT的视频
    private function storeCompound(Request $request)
    {
        $item = new Video();
        $item->video_type = "compound";
        $item->mime = "video/";
        auth()->user()->videos()->save($item);
        return redirect()->route('videos.edit', ['id' => $item->id]);
    }

    /**
     * 改变图片顺序
     * @param Request $request
     * @param $videoId
     * @return mixed
     */
    public function updateAttachmentOrder(Request $request, $videoId)
    {
        $data = $request->get('data');
//        dd($data);//array:8 [ 0 => array:2 [ "id" => "33" "no" => "0" ] 1 => array:2 [ "id" => "34" "no" => "1" ] 2 => array:2 [ "id" => "18" "no" => "2" ] 3 => array:2 [ "id" => "22" "no" => "3" ] 4 => array:2 [ "id" => "19" "no" => "4" ] 5 => array:2 [ "id" => "23" "no" => "5" ] 6 => array:2 [ "id" => "17" "no" => "6" ] 7 => array:2 [ "id" => "16" "no" => "7" ] ]
        $sql = '';
        foreach ($data as $item) {
//            var_dump($item['id']);
            $sql .= sprintf('update video_attachment set no=%s where video_id=%s and attachment_id=%s; ', $item['no'], $videoId, $item['id']);
            $affected = DB::update(sprintf('update video_attachment set no=%s where video_id=%s and attachment_id=%s; ', $item['no'], $videoId, $item['id']));

        }
        return $affected;
    }

    /**
     * 调用腾讯云接口获取视频信息
     * @param Request $request
     * @param Video $video
     * @return string
     */
    public function cloudInfo(Request $request, Video $video)
    {
        $vod = new VodApi();
        $vod->Init(config('services.vod.secretId'), config('services.vod.secretKey'), VodApi::USAGE_VOD_REST_API_CALL, "gz");
        $arguments = array(
            'Action' => 'GetVideoInfo',
            'fileId' => $video->cloud_file_id,
            'contentLen' => 0,
        );
        ob_start();
        list($ret, $response) = $vod->CallMyRestApi($arguments);
        $log = ob_get_contents();
        ob_end_clean();
        Log::info($log);
        if ($ret != 0) {
            return 'error';
        }
        dd($response);
        return $response;
    }

    /**
     * 调用腾讯云视频转码接口
     * @param Request $request
     * @param Video $video
     * @return string
     */
    public function cloudTranscode(Request $request, Video $video)
    {
        list($ret, $response) = $this->callCloudTranscodeApi($video);
        if ($ret != 0) {
            return 'error';
        }
//        return $response;
        return redirect()->route('videos.index');
    }

    /**
     * 调用腾讯云视频转码接口
     * @param Video $video
     * @return mixed
     */
    public function callCloudTranscodeApi(Video $video)
    {
        $vod = new VodApi();
        $vod->Init(config('services.vod.secretId'), config('services.vod.secretKey'), VodApi::USAGE_VOD_REST_API_CALL, "gz");
        $arguments = array(
            'Action' => 'ConvertVodFile',
            'fileId' => $video->cloud_file_id,
            'contentLen' => 0,
        );
        ob_start();
        list($ret, $response) = $vod->CallMyRestApi($arguments);
        $log = ob_get_contents();
        ob_end_clean();
        Log::info($log);
        return [$ret, $response];
    }

//接收点播服务端回调 假定回调URL为https://www.example.com/path/to/your/service。

    public function cloudCallback(Request $request)
    {
//        TODO  这个功能只能线上环境测试
        $response = json_decode($request->getContent());
        $status = $response->data->status;
        if ($status == 2) {
            $fileId = $response->data->fileId;
            $video = Video::where('cloud_file_id', $fileId)->first();
            $video->status = "ok";
            $video->save();
            return 2;
        }
        return 'error';
    }

}
