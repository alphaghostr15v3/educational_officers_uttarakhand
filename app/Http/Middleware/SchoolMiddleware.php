<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('school.login')->with('error', 'Please login to access the school panel.');
        }

        if (auth()->user()->role !== 'school') {
            abort(403, 'Unauthorized access - School Panel privileges required.');
        }

        return $next($request);
    }
}
