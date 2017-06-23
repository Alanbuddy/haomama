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
        $message = new Message();
        if ($attributes['object_type'] == 'comment') {
            $existingMessage = Message::where('object_id', $attributes['object_id'])->first();
            $message = $existingMessage ?: $message;
        }
        $message->fill($attributes);
        if ($existingMessage) {
            $message->update();
        } else {
            $message->save();
        }
    }
}