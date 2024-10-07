<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class CountVisitor
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
        $ip = hash('sha512', $request->ip());
        if (Visitor::where('date', today())->where('ip', $ip)->count() < 1)
        {
            Visitor::create([
                'date' => today(),
                'ip' => $ip,
            ]);
        }
        return $next($request);
    }
}
