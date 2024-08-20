<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        // if (!Auth::check() || !Auth::user()->hasRole($role)) {
        //     return redirect('/home')->with('error', 'Access denied.');
        // }

        return $next($request);
    }
}
