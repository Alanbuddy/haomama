<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-6
 * Time: 下午4:59
 */

namespace App\Http\Controllers\Auth;


use App\Http\Sms\SmsApi;
use Illuminate\Http\Request;

trait SendsPasswordResetSms
{

    public function sendResetSms(Request $request)
    {
//        baby.com/password/sms/send?phone=18911209450
        $this->validate($request, ['phone' => 'required|digits:11']);
        $response = SmsApi::send($request);
        dd($response);
        if ($response['code'] == 200) {
            echo 'success';
        }
        return 2;
    }
}