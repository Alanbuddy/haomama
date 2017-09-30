<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-8-9
 * Time: 下午4:22
 */

namespace App\Services;

require_once 'phpqrcode.php';
class QR
{
    public static function qr($data)
    {
        \QRcode::png($data);
    }
}