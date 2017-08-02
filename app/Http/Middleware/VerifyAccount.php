<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-4-27
 * Time: 下午4:34
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyAccount
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
        $user = auth()->user();
        if ($user && $user->hasRole('operator') && $user->status != 'enabled') {
            Auth::logout();
            return redirect()->route('login')->with('user',$user);
        }
        return $next($request);
    }
}
