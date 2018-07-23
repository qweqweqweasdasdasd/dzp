<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Anquan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        //判断当前用户使用什么设备
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_iphone  = (strpos($agent, 'iphone')) ? true : false;
        $is_ipad  = (strpos($agent, 'ipad')) ? true : false;
        $is_android  = (strpos($agent, 'android')) ? true : false;
        if($is_iphone || $is_ipad || $is_android){
            return redirect('login');
        }

        //当前的用户是否session失效
        if(!Auth::guard('back')->check()){
            return redirect('login');
        }
        return $next($request);
    }
}
