<?php

namespace App\Http\Util;

use Illuminate\Http\Request;
use App\Models\File;

/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-3
 * Time: 下午4:11
 */
trait IO
{

    //移动上传的文件到指定位置并保存文件信息到数据库
    public function moveAndStore(Request $request, $key, $folderPath, $store = true)
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
}