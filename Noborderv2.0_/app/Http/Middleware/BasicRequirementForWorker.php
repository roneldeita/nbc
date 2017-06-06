<?php

namespace App\Http\Middleware;

use Closure;

class BasicRequirementForWorker
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
        if (count($request->user()->skills) == 0 ) {
            return redirect('/worker/skills');
        }
        return $next($request);
    }
}
