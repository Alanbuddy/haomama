<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-6
 * Time: 下午4:59
 */

namespace App\Http\Controllers\Auth;


use App\Http\Sms\SendSms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

trait SendsPasswordResetSms
{

    use SendSms;

//http://www.baby.com/password/sms/send?phone=18911209450
    public function sendResetSms(Request $request)
    {
        $this->validate($request, ['phone' => 'required|digits:11']);
        $code = rand(100000, 999999);
        $content = '验证码:' . $code;
        $result = self::sendSms([$request->get('phone')], $content);
//        $result = ['success' => true];
        if ($result['success']) {
            $user = $this->myBroker()->getUser($request->only('phone'));
            if (is_null($user)) {
                return ['success' => false, 'message' => '用户不存在'];
            }
            $response = $this->myBroker()->createCustomToken($user, $code);
//            dd($response, $code);
            return ['success' => true];
//            return ['success' => true, 'data' => $response];

        } else {
            return ['success' => false, 'message' => '发送失败', 'data' => $result];
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function myBroker()
    {
        return Password::broker('sms');
    }

}