<?php

namespace App\Jobs;

use App\Http\Controllers\ErrorTrait;
use App\Http\Controllers\VideoController;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TecentVodUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ErrorTrait;


    protected $file;

    /**
     * Create a new job instance.
     *
     * @param $filePath
     * @param null $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $videoController = app(VideoController::class);
        list($vod, $ret) = $videoController->callVodUploadApi($this->file->path);
        if ($ret == 0) {
            $this->file->cloud_file_id = $vod->getFileId();
            $this->file->video_status = 'transcoding';
            list($ret2, $response) = $videoController->callCloudTranscodeApi($vod->getFileId());//转码API
            Log::info(__FILE__ .__LINE__. "\n转码结果：" . $ret2);
            Log::info(__FILE__ . "\n" . json_encode($response) . __FILE__);
            $this->file->size = filesize($this->file->path);
            Log::info($this->file->id);
            $this->file->save();
            Storage::delete(substr($this->file->path, strpos($this->file->path, 'video')));
            Log::info('has deleted temp video file!');

        } else {
            $this->file->video_status = '';
            $this->file->save();
        }
        Log::info(__FILE__ . ':' . __LINE__ . '上传任务' . ($ret == 0 ? '成功' : '失败'));
    }

    public function failed(Exception $e)
    {
        // 给用户发送失败通知，等等...
        $this->logError('vod.upload', '上传任务失败' . $e->getMessage(), $this->file, json_encode($e));
    }
}
