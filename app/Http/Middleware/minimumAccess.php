<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class minimumAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $minRole)
    {
        switch($minRole){
            case 'Admin':
                if (Auth::user()->role != 'Admin')
                    abort(403, "Unauthorized");
                break;
            case 'Editor':
                if (Auth::user()->role != 'Admin' && Auth::user()->role != 'Editor')
                abort(403, "Unauthorized");
                break;
            case 'User':
                if (!isset(Auth::user()->id))
                    return redirect('/login');
        }
        return $next($request);
    }
}
