<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$role): Response
    {
        $user = Auth()->user();
        
        if (!$user) {
               return redirect()->route('login')->with('errors', 'Silahkan login terlebih dahulu');
        }
        
        if (!in_array($request->user()->role, $role)) {
            abort(403);
        }

        return $next($request);
       
    }
}