<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-5
 * Time: 上午10:29
 */

namespace App\Http\Controllers;


use App\Models\Error;

trait ErrorTrait
{
    public function logError($type, $message, $data='', $context='')
    {
        Error::create([
            'user_id' => auth()->user()->id,
            'type' => $type,
            'message' => $message,
            'data' => $data,
            'context' => $context
        ]);
    }

}