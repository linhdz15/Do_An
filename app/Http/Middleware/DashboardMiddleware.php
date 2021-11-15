<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DashboardMiddleware
{
    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->canBeAdministrators()) {
            return redirect('/')->withErrors(__('auth.not_authorized'));
        }

        return $next($request);
    }
}
