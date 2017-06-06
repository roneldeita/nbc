<?php

namespace App\Http\Middleware;

use Closure;

class HasRoleAlready
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
        if ( ($request->user()->role != 0 || $request->user()->role != '0') || $request->user()->role != null  ) {
            //return redirect('/');
            if ($request->user()->role == 1) {
                return redirect('/client');
            } else if ($request->user()->role == 2) {
                return redirect('/worker');
            } else if ($request->user()->role == 3) {
                return redirect('/coordinator');
            }
        }
        return $next($request);
    }
}
