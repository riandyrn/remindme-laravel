<?php

namespace App\Http\Middleware;

use App\Models\ResponseTemplate;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BearerTokenMustExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if (is_null($bearerToken) or empty($bearerToken)) {
            if ($request->method() == 'POST') {
                return response()->json(ResponseTemplate::errUnauthorized(), 401);
            } else if ($request->method() == 'PUT') {
                return response()->json(ResponseTemplate::errInvalidRefreshToken(), 401);
            } else {
                return response()->json(ResponseTemplate::err405(), 405);
            }
        }

        return $next($request);
    }
}
