<?php

namespace App\Http\Controllers;

use App\Http\Util\IO;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use IO;

    /**
     * 返回值中的path属性表示上传到服务器的文件相对web根目录的地址
     * 返回值中的data属性表示文件在数据库中对应的一条记录
     * @param Request $request
     * @return array|bool
     */
    public function upload(Request $request)
    {
        if ($request->has('chunks')) {
            return $this->chunkUpload($request);
        }
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->move(public_path('app'), $fileName);
        $item = new File();
        $item->path = substr($path->getPathname(), strlen(public_path()));
        $item->user_id = auth()->user()->id;
        $item->fill($this->getFileBaseInfo($file));
        $item->save();
        $path = substr($path->getPathName(), strlen(public_path()));
        if ($request->has('editor'))
            return ['errno' => 0, 'data' =>[ env('APP_URL') . $path]];
        return ['success' => true, 'path' => $path, 'data' => $item];
    }

    public function initChunkUpload(Request $request)
    {
        $file = new File();
        auth()->user()->files()->save($file);
        return ['success' => true, 'data' => $file];
    }

    public function chunkUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
            'chunk' => 'required',
            'file_id' => 'required',
        ]);
        if ($request->chunk == 0) {
            $file = File::find($request->file_id);
            $file->description = $request->chunks;
            $attr = $this->getFileBaseInfo($request->file('file'));
            $file->fill($attr);
            if ($request->has('mime')) {
                $file->mime = $request->mime;
            }
            $file->save();
        }
        return $this->uploadChunkedFile($request);
    }

    public function mergeFile(Request $request)
    {
        $this->validate($request, ['file_id' => 'required']);
        $file = File::find($request->file_id);
        $ret = $this->merge($request, $file->description);
        $file->path=substr($ret['path'],strlen(public_path()));
        $file->save();
        return $ret;
    }
}
