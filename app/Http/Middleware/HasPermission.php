<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Validation\UnauthorizedException;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        if ($request->user()) {
            foreach ($permissions as $permission) {
                if ($request->user()->can($permission)) {
                    return $next($request);
                }
            }
        }
        throw new UnauthorizedException("You are not authorized for such request!", 403);

    }
}
