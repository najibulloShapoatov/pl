<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Booker
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
        {if(Auth::check()){
            if(Auth::user() && Auth::user()->isBooker()){
                return $next($request);
            }
            return redirect('/');
        }
            return redirect('/');
        }
    }
}
