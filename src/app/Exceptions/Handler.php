<?php

namespace App\Exceptions;

use App\Helpers\Constant;
use App\Helpers\Helper;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $this->renderable(function (Exception $e) {
            return $this->handleException($e);
        });
    }

    /**
     * Check and Handle somes Exception
     *
     * @param  Exception  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function handleException(Exception $exception): \Illuminate\Http\JsonResponse
    {
        if ($exception instanceof NotFoundHttpException) {
            if ($exception->getPrevious() instanceof ModelNotFoundException) {
                return Helper::apiErrorResponse('resource is not found', Constant::ERR_NOT_FOUND, Response::HTTP_NOT_FOUND);
            }

            return Helper::apiErrorResponse('resource is not found', Constant::ERR_NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof ValidationException) {
            return Helper::apiErrorResponse($exception->getMessage(), Constant::ERR_BAD_REQUEST, Response::HTTP_BAD_REQUEST);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return Helper::apiErrorResponse('method not allowed', Constant::ERR_BAD_REQUEST, Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return Helper::apiErrorResponse("user doesn't have enough authorization", Constant::ERR_FORBIDDEN_ACCESS, Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AuthenticationException) {
            return Helper::apiErrorResponse('invalid access token', Constant::ERR_INVALID_ACCESS_TOKEN, Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof AuthorizationException) {
            return Helper::apiErrorResponse('invalid access token', Constant::ERR_INVALID_ACCESS_TOKEN, Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ApiErrorException) {
            return Helper::apiErrorResponse($exception->getMessage(), $exception->getErrCode(), $exception->getCode());
        }

        if ($exception instanceof HttpExceptionInterface) {
            return Helper::apiErrorResponse($exception->getMessage(), Constant::ERR_INTERNAL_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Helper::apiErrorResponse($exception->getMessage(), Constant::ERR_INTERNAL_ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
