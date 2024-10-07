<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsActiveAndHasProperRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            abort(404);
        }

        $user = auth()->user();

        if (!$user->isActive() || $user->role !== $role) {
            if($user->isAdmin()){
                setSessionResponseMessage('You are logged in as Admin, and Admin can`t access this page.', 'error');
                return redirect('/');
            }
            abort(403);
        }

        return $next($request);
    }
}
