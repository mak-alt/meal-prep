<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NameCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isAdmin()){
            return $next($request);
        }
        if (auth()->check() && (auth()->user()->first_name === null && auth()->user()->last_name === null)){
            if ($request->ajax()){
                return response()->json([
                    'status' => 'success',
                    'message' => null,
                    'data' => [
                        'redirect' => route('frontend.profile.index'),
                    ]
                ]);
            }
            else{
                return redirect()->route('frontend.profile.index');
            }
        }
        else{
            return $next($request);
        }
    }
}
