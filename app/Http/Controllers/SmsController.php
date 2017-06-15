<?php

namespace App\Http\Controllers;

use App\Http\Sms\SmsApi;
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
        if ($request->has('code')) {
            // var_dump($request->all());
            $result = $request->code == session('code');
            return ['success' => $result];
        }
        return ['success' => false];
    }
}