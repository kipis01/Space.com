<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class langMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->cookie('language');
        if (!empty($lang)){
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
