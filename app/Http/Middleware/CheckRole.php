<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
namespace App\Http\Middleware;



use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        $user = Auth::user();

        foreach ($roles as $role) {
            // If the user role matches one of the allowed roles, the pass is granted

            if ($user->role === $role) {
                return $next($request);
            }
        }



        abort(403, 'You do not have permission to access this page.');
    }
}
