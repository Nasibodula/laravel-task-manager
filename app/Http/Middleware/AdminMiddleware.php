<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Your admin check logic here
        if (!auth()->user() || !auth()->user()->is_admin) {
            return redirect('/login');
        }
        
        return $next($request);
    }
}
