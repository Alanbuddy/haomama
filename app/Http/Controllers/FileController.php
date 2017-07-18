<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = $file->move(public_path('app'), $fileName);
        return ['success' => true, 'path' =>substr($path,strlen(public_path()))];
    }
}
