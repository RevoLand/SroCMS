<?php

namespace App\Http\Middleware;

use Closure;
use Theme;

class Admin
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
        Theme::set('admin');

        return $next($request);
    }
}
