<?php

namespace SaadeMotion\Photofolio\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PhotofolioAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        auth()->setDefaultDriver('web');

        if (Auth::guest()) {
            return redirect()->guest(route('photofolio.login'));
        }
        
        return $next($request);
    }
}
