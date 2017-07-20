<?php

namespace App\Http\Util;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-3
 * Time: 下午4:11
 */
trait IO
{

    //移动上传的文件到指定位置并保存文件信息到数据库
    public function moveAndStore(Request $request, $key, $folderPath='', $store = true)
    {
        $folderPath = $folderPath ?: public_path('storage');
        $file = $request->file($key);
        $moved = $file->move($folderPath, $file->getClientOriginalName());
        if ($store) {
            $item = new File();
            $item->path = substr($moved->getPathname(), strlen(public_path()));
            $item->user_id = auth()->user()->id;
            $item->fill($this->getFileBaseInfo($file));
            $item->save();
            return $item;
        } else {
            return $moved;
        }
    }

    public function getFileBaseInfo($file)
    {
        $item['file_name'] = $file->getClientOriginalName();
        $item['mime'] = $file->getClientMimeType();
        $item['extension'] = $file->getClientOriginalExtension();
        $item['size'] = $file->getClientSize();
        return $item;
    }

    /**
     * @param Request $request
     * @return bool
     * @internal param null|Closure $beforeUpload
     */
    public function uploadChunkedFile(Request $request)
    {
        $index = $request->get('chunk');
        $name = $request->get('name');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $size = $file->getSize();
//            $path = storage_path('app/' . md5(uniqid(rand(), true))); //$path = storage_path('/' . date('Ymd-His', time()));
            $path = storage_path('app/' . md5($name)); //$path = storage_path('/' . date('Ymd-His', time()));
            if (!is_dir($path)) {
                $result = mkdir($path, 0777, true);
                if (!$result) return false;
            }
            $filename = $name . $index;
            $file->move($path, $filename);
            Log::info('chunk size' . $size);
            return ['success' => true];
        }

    }

    public function merge(Request $request,$chunksCount)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $fileName = $request->get('name');
        $dir = storage_path('app/' . md5($fileName));
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $targetPath = $dir . DIRECTORY_SEPARATOR . $fileName;
        $dst = fopen($targetPath, 'wb');
        Log::info('about to merge ' . $chunksCount . 'chunks');
        for ($i = 0; $i < $chunksCount; $i++) {
            $chunk = $dir . DIRECTORY_SEPARATOR . $fileName . $i;
            $src = fopen($chunk, 'rb');
            stream_copy_to_stream($src, $dst);
            fclose($src);
            unlink($chunk);
            Log::info('merged chunk' . $chunk);
        }
        return ['success' => true, 'path' => $targetPath, 'fileName' => $fileName];
    }
}