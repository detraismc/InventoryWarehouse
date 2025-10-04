<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request and check if the user has one of the allowed roles.
     *
     * @param Request $request
     * @param Closure $next
     * @param string ...$roles Allowed roles passed as parameters
     * @return Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the authenticated user's role is in the list of allowed roles
        if (! in_array($request->user()->role, $roles)) {
            // If not, abort with 403 Forbidden
            abort(403, 'Unauthorized access.');
        }

        // If the user has the required role, continue to the next middleware/request handler
        return $next($request);
    }
}
