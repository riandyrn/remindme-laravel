<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\DataTransferObjects\Auth\RegisterDto;
use App\DataTransferObjects\Auth\LoginDto;
use App\DataTransferObjects\Auth\RefreshTokenDto;
use App\Helpers\ApiFormatter;
use Illuminate\Http\JsonResponse;
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

            if ( $results && $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    $results['error_code'],
                    $results['message'],
                    $results['status_code'],
                );
            }

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {

            $results = $this->authService->login(
                LoginDto::fromApiRequest($request)
            );

            if ( $results && $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    $results['error_code'],
                    $results['message'],
                    $results['status_code'],
                );
            }

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }

    public function refreshToken(Request $request): JsonResponse
    {
        try {
            $results = $this->authService->refreshToken(
                RefreshTokenDto::fromApiRequest($request)
            );

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }
}
