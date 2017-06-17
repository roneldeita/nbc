<?php

namespace App\Http\Middleware;

use Closure;

class NoRoleYet
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
        if ($request->user()->role == 0 || $request->user()->social) {
            return redirect('/selectRole');
        }
        return $next($request);
    }
}
