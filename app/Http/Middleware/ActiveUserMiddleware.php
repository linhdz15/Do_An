<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUserMiddleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->isActive()) {
            return redirect('/')->withErrors(__('auth.not_authorized'));
        }

        return $next($request);
    }
}
