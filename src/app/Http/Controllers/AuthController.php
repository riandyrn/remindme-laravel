<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiErrorException;
use App\Helpers\Constant;
use App\Helpers\Helper;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return Helper::apiResponse($this->authService->login($request->validated()));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        if (!$request->user()->tokenCan(Constant::CAN_ISSUE_ACCESS_TOKEN)) {
            throw new ApiErrorException(Constant::ERR_INVALID_REFRESH_TOKEN, 'invalid refresh token', Response::HTTP_UNAUTHORIZED);
        }
        return Helper::apiResponse($this->authService->refreshToken($request));
    }
}
