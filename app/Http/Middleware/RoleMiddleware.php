<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $values)
    {
        $values = is_array($values) ? $values : explode('|', $values);

        if (! $request->user()->hasRole($values)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
