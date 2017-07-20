<?php

namespace App\Http\Controllers;

use App\Http\Util\IO;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use IO;

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
        return ['success' => true, 'path' => substr($path->getPathName(), strlen(public_path())), 'data' => $item];
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
        if ($request->chunk == 0 || !$request->has('chunk')) {
            $file = File::find($request->file_id);
            $file->fill($this->getFileBaseInfo($file));
            $file->description = $request->chunks;
            $file->save();
        }
        return $this->uploadChunkedFile($request);
    }

    public function mergeFile(Request $request)
    {
        $file = File::find($request->file_id);
        $ret = $this->merge($request, $file->description);
        return $ret;
    }
}
