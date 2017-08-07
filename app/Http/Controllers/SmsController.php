<?php

namespace App\Http\Controllers;

use App\Http\Sms\SmsApi;
use App\Models\User;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    function __construct()
    {
    }

    public function send(Request $request)
    {
        $response = SmsApi::send($request);
        if ($response['success']) {
            $arr = explode('|', $response['data']);
            if ($arr[0] == 1) {
                return ['success' => true];
            }
        }
        return ['success' => false, 'message' =>$response['message']];
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
        return SmsApi::verify($request);
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
