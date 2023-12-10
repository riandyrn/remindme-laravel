<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\DataTransferObjects\Auth\RegisterDto;
use App\DataTransferObjects\Auth\LoginDto;
use App\Services\AuthService;
use Exception;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {

            $results = $this->authService->register(
                RegisterDto::fromApiRequest($request)
            );

            if ( $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    false,
                    $results['error_code'],
                    $results['message']
                );
            }

            return ApiFormatter::responseSuccess(
                true,
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                false,
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
            );

        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {

            $results = $this->authService->login(
                LoginDto::fromApiRequest($request)
            );

            if ( $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    false,
                    $results['error_code'],
                    $results['message']
                );
            }

            return ApiFormatter::responseSuccess(
                true,
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                false,
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
            );

        }
    }
}
