<?php

namespace App\Http\Middleware;

use Closure;

class AdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->is("admin") or $request->user()->is("dev") )
            return $next($request);

        abort(403, "unauthorised request");
    }
}
