<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccessMiddleware
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
        if (
            $request->user() &&
            $request->user()->hasPermission(config('permissions.access_key'))
        ) {
            return $next($request);
        }

        abort(Response::HTTP_FORBIDDEN);
    }
}
