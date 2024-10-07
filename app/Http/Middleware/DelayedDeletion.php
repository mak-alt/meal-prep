<?php

namespace App\Http\Middleware;

use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Closure;
use Illuminate\Http\Request;

class DelayedDeletion
{
    public const BASE_SESSION_KEY = 'delayed-deletion';

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax() || !session()->has(self::BASE_SESSION_KEY)) {
            return $next($request);
        }

        foreach (session()->get(self::BASE_SESSION_KEY) as $key => $value) {
            if ($key === ShoppingCartSessionStorageService::SESSION_KEY) {
                ShoppingCartSessionStorageService::forget($value);
                session()->forget(self::BASE_SESSION_KEY . '.' . ShoppingCartSessionStorageService::SESSION_KEY);
            }
        }

        return $next($request);
    }
}
