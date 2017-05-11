<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lib\Vod\VodApi;

class VodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return $request->getContent();
        return view('video.display');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function video()
    {
        return view('video.display');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $file = "/home/gao/sefie shoes.mp4";
        $file = "/home/gao/purple.mp4";
        $vod = new VodApi();
        $vod->Init("AKIDd2B4h6g8nGSO3eC7yax4vXkkZ9asllMi", "HIdjeQxFH4cv0qTr44qNhlZ8SZQ3ax4v", VodApi::USAGE_UPLOAD, "gz");

        $vod->SetConcurrentNum(10);    //设置并发上传的分片数目，不调用此函数时默认并发上传数为6
        $vod->SetRetryTimes(10);    //设置每个分片可重传的次数，不调用此函数时默认值为5

// $package: 上传的文件配置参数
        $package = array(
//            'fileName' => $argv[1],                //文件的绝对路径，包含文件名
//            'fileName' => '/swapfile',
            'fileName' => $file,
            'dataSize' => 1024 * 1024,            //分片大小，单位Bytes。断点续传时，dataSize强制使用第一次上传时的值。
            'isTranscode' => 0,                    //是否转码
            'isScreenshot' => 1,                //是否截图
            'isWatermark' => 0,                    //是否添加水印
            'classId' => 0                        //分类
        );

        $vod->AddFileTag("测试1");
        $vod->AddFileTag("测试2");
        $ret = $vod->UploadVideo($package);
        if ($ret !== 0) {
            echo "upload error\n";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
