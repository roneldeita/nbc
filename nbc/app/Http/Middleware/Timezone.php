<?php

namespace App\Http\Middleware;

use Closure;

class Timezone
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
        $this->setTimeZone($request);
        return $this->addTimeZoneCookie($request, $next($request));
    }

    public function setTimeZone($request) {
        if ($request->cookie('time_zone')) {
            return date_default_timezone_set($request->cookie('time_zone'));
        }
        return date_default_timezone_set($request->user()->timezone);
    }

    public function addTimeZoneCookie($request, $response)
    {
        if(! $request->cookie('time_zone') && ! is_null($request->user()->timezone))
        {
            return $response->withCookie(cookie('time_zone', $request->user()->timezone, 120));
        }
        return $response;
    }
}
