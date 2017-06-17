<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifiedEmail
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
        if ($request->user()->verification !== null && $request->user()->verified === 0) {
            if ($request->user()->role === 1) {
                return redirect('/client/notVerified');
            } else if ($request->user()->role === 2 ) {
                return redirect('/worker/notVerified');
            } else {
                return redirect('errors/404');
            }
            
        } 
        return $next($request);
    }
}
