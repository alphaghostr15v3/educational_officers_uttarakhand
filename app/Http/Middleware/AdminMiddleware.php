<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Admin roles: state_admin, division_admin, district_admin
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel.');
        }

        $user = auth()->user();

        // Check if user has an admin role
        $adminRoles = ['state_admin', 'division_admin', 'district_admin'];
        
        if (!in_array($user->role, $adminRoles)) {
            abort(403, 'Unauthorized access - Administrative privileges required.');
        }

        return $next($request);
    }
}
