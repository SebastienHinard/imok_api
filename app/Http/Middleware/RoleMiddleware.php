<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Si le role du user ne corresponds pas
        if ($request->user()->getRole() != $role) {
            return response('Access forbidden.', 403);
        }

        return $next($request);
    }

}
