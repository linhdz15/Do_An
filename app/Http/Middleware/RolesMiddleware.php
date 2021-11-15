<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RolesMiddleware
{
    /**
     * Handle the incoming request.
     * @param Request $request
     * @param Closure $next
     * @param array $roles
     * @return RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        if ($request->user()) {
            foreach($roles as $role) {
                if ($request->user()->hasRole($role)) return $next($request);
            }
        }

        return redirect('/')->withErrors(__('auth.not_authorized'));
    }
}
