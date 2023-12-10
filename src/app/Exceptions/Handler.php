<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Auth\AuthenticationException;
use App\Enums\TokenAbility;
use App\Helpers\ApiFormatter;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ( $request->is('api/*') ) {
                return ApiFormatter::responseError(
                    false,
                    'ERR_UNAUTHORIZED_401',
                    $e->getMessage(),
                );
            }
        });

        $this->renderable(function (Throwable $e, $request) {

            if ( $request->is('api/*') ) {
                if ( $request->user() &&
                    ( !$request->user()->tokenCan(TokenAbility::ACCESS_API->value) or
                    !$request->user()->tokenCan(TokenAbility::ISSUE_ACCESS_TOKEN->value) )
                ) {
                    return ApiFormatter::responseError(
                        false,
                        'ERR_UNAUTHORIZED_401',
                        $e->getMessage(),
                    );
                }

                return parent::render($request, $e);
            }
        });
    }
}
