<?php

namespace App\Http\Middleware;

use DB;
use Closure;

class UseCheck
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
        $user = session('username');
        if(!$user){
           return redirect('/');
        };
        $session_id = DB::table('member')->where('mem_no',$user)->value('session_id');
        if(session()->getId() != $session_id){
            session()->forget('username');
            return redirect('/');
        };
        return $next($request);
    }
}
