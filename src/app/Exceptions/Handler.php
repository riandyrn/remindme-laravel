<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Enums\TokenAbility;
use Illuminate\Auth\AuthenticationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
        $this->renderable(function (Exception $e, $request) {
            if ($request->is('api/*')) {
                if ($e->getPrevious() instanceof MissingAbilityException) {
                    return response()->json([
                        'ok' => false,
                        'err' => 'ERR_INVALID_REFRESH_TOKEN',
                        'msg' => 'invalid refresh token'
                    ], 401);
                }
            }
        });
    }
}
