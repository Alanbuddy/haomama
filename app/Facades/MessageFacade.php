<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-15
 * Time: 上午10:20
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MessageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'message';
    }
}
