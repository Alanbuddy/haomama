<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-4-27
 * Time: 下午4:34
 */

namespace App\Http\Middleware;

use Closure;

class Weixin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = '06cf9d408ab6ea656a996ed0e1819a9f';
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');
        $tmpArr = [$token, $timestamp, $nonce];//var_dump($tmpArr);
        sort($tmpArr, SORT_STRING);
        $str = implode($tmpArr);
        $signature = sha1($str);
        if ($signature != $request->get('signature')) {
            return 'Not Allowed';
        }
        return $next($request);
    }
}
