<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Http\Models\Manager;

class Fangqiang
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

        //获取到当前的管理员id
        $mg_id = \Auth::guard('back')->user()->manager_id;
        //非 root 用户
        if($mg_id != 1){
            $ps_ca = Manager::find($mg_id)->role->ps_ca;
            //获取到当前的控制器+方法
            $nowCA = getCurrentControllerName() . '-' . getCurrentMethodName();
            if(strpos($ps_ca,$nowCA) === false){
                exit('您不具备该方法的权限!');
            }

        };
        return $next($request);
    }
}
