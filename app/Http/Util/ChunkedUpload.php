<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-13
 * Time: 下午4:07
 */

namespace App\Http\Util;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Closure;

trait ChunkedUpload
{
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
//            $path = storage_path('app/' . md5(uniqid(rand(), true))); //$path = storage_path('/' . date('Ymd-His', time()));
            $path = storage_path('app/' . md5($name)); //$path = storage_path('/' . date('Ymd-His', time()));
            if (!is_dir($path)) {
                $result = mkdir($path, 0777, true);
                if (!$result) return false;
            }
            $filename = $name . $index;
            $file->move($path, $filename);
            Log::info('chunk size' . $file->getSize());
            return true;
        }

    }

    public function merge(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'count' => 'required',
        ]);
        $fileName = $request->get('name');
        $chunksCount = $request->get('count');
        $dir = storage_path('app/' . md5($fileName));
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $targetPath = $dir . $fileName;
        $dst = fopen($targetPath, 'wb');
        Log::info('about to merge ' . $chunksCount . 'chunks');
        for ($i = 0; $i < $chunksCount; $i++) {
            $chunk = $dir . $fileName . $i;
            $src = fopen($chunk, 'rb');
            stream_copy_to_stream($src, $dst);
            fclose($src);
            unlink($chunk);
            Log::info('merged chunk' . $chunk);
        }
        return ['success' => true, 'file' => $targetPath];
    }
}