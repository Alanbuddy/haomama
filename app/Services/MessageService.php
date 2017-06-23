<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-15
 * Time: 上午9:34
 */

namespace App\Services;



use App\Models\Message;

class MessageService
{
    public function send($attributes)
    {
        $message=new Message();
        $message->fill(attributes);
        $message->save();
    }
}