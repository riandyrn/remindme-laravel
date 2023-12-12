<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthRToken extends Middleware
{
   /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'ok' => false,
            'err' => 'ERR_INVALID_REFRESH_TOKEN',
            'msg' => 'invalid refresh token'
        ], 401));
    }
}
