<?php
namespace App\Http\Controllers;

use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RefreshTokenRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addSeconds(20));
            $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addDays(7));

            return response()->json([
                'ok' => true,
                'data' => [
                    'user' => new UserResource($user),
                    'access_token' => $token->plainTextToken,
                    'refresh_token' => $refreshToken->plainTextToken,
                ],
            ]);
        } else {
            return response()->json([
                'ok' => false,
                'err' => 'ERR_INVALID_CREDS',
                'msg' => 'Incorrect username or password',
            ], 401);
        }
    }
    
    public function refreshAccessToken(RefreshTokenRequest $request)
    {
        $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addSeconds(20));
        return response()->json([
            "ok" => true,
            "data" => [
                "access_token" => $accessToken->plainTextToken
            ]
        ]);
    }
}