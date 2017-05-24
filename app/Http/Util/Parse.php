<?php

namespace App\Http\Util;
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-3
 * Time: 下午4:11
 */
trait Parse
{
    public function parseCsv($str)
    {
        $str = chop($str);
        $arr = explode(PHP_EOL, $str);
//        return $arr;

        $ret = [];
        foreach ($arr as $item) {
            $pos = strpos($item, ',');
            $tmp = [];
            $tmp['time'] = substr($item, 0, $pos);
            $tmp['content'] = substr($item, $pos + 1);
            $ret[] = $tmp;
        }
        return $ret;
    }

    public function parseTimeline($str)
    {
        $str = chop($str);
        $arr = explode(PHP_EOL, $str);
        return $arr;
    }
}