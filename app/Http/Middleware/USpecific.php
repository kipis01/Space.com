<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class USpecific
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $id = null)
    {
        if($id != null);
        if (!isset(Auth::user()->id))
            abort(403, "Unauthorized");
        else if(Auth::user()->id == $request->id || Auth::user()->role == "Admin")
            return $next($request);
        else return abort(403, "Unauthorized");
    }
}
