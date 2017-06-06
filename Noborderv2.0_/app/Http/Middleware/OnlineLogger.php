<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class OnlineLogger
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
        if ($request->user()) {
            if ($request->user()->online == 1 || $request->user()->online == "1") {

            }
            $user = User::find($request->user()->id);
            $user->online = 1;
            $user->save();
            
            return $next($request);
        }
        return $next($request);
    }
}
