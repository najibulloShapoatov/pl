<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;
use Symfony\Contracts\EventDispatcher\Event;

class StartSession
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
        return $next($request);
    }

    protected function startSession(Request $request)
    {
        $session = parent::startSession($request);

        Event::fire('session.started');

        return $session;
    }
}


