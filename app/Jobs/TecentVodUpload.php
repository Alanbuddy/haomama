<?php

namespace App\Jobs;

use App\Http\Controllers\VideoController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TecentVodUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    protected $file;

    /**
     * Create a new job instance.
     *
     * @param $filePath
     * @param null $file
     */
    public function __construct($filePath, $file)
    {
        $this->filePath = $filePath;
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
        list($vod, $ret) = $videoController->callVodUploadApi($this->filePath);
        if ($ret == 0) {
            $this->file->cloud_file_id = $vod->getFileId();
            list($ret2, $response) = $videoController->callCloudTranscodeApi($vod->getFileId());
            Log::info(__FILE__ . "\n转码结果：" . $ret2);
            Log::info(__FILE__ . "\n" . json_encode($response) . __FILE__);
            $this->file->video_status = 'transcoding';
            $this->file->size = filesize($this->filePath);
            Log::info($this->file->id);
            $this->file->save();
            Storage::delete(substr($this->file->path, strpos($this->file->path,'video')));
            Log::info('has deleted temp video file!');

        } else {
            $this->file->video_status = '';
            $this->file->save();
        }
        Log::info(__FILE__ . ':' . __LINE__ . '上传任务' . ($ret == 0 ? '成功' : '失败'));
    }
}
