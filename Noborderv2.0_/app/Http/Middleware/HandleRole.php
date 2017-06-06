<?php

namespace App\Http\Middleware;

use Closure;

class HandleRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->role != $role) {
            return redirect('errors/403');
        }
        return $next($request);
    }
}
