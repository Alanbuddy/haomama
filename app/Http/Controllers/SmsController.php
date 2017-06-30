<?php

namespace App\Http\Controllers;

use App\Http\Sms\SmsApi;
use App\Models\User;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send(Request $request)
    {
        $response = SmsApi::send($request);
        return ['success' => true];
        if ($response['code'] == 200) {
            $arr = explode('|', $response['data']);
            if ($arr[0] == 1) {
                return ['success' => true];
            }
        }
        return ['success' => false, 'message' => $arr[2]];
    }

    public static function residual()
    {
        $response = SmsApi::residual();
        if ($response['code'] == 200) {
            return ['success' => true, 'data' => $response];
        }
    }

    public static function verify(Request $request)
    {
        if ($request->has('code') && $request->has('mobile')) {
            $result = ($request->code == session('code')) &&
                ($request->mobile == session('mobile'));
            return ['success' => $result];
        }
        return ['success' => false];
    }

    //判断手机号有没有占用
    //返回示例: {"isOccupied":false}
    public function isOccupied(Request $request)
    {
        $phone = $request->phone;
        $isOccupied = (bool)User::where('phone', $phone)->count();
        return compact('isOccupied');
    }
}
