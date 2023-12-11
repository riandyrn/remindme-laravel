<?php

namespace App\Services;

use App\Exceptions\ApiErrorException;
use App\Helpers\Constant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $input): array
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', $input['email'])
            ->first();
        if (empty($user)) {
            throw new ApiErrorException(Constant::ERR_INVALID_CREDS, 'incorrect username or password', Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($input['password'], $user->password)) {
            throw new ApiErrorException(Constant::ERR_INVALID_CREDS, 'incorrect username or password', Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = $user->createToken('access_token', [Constant::CAN_ACCESS_API], now()->addSeconds(Constant::ACCESS_TOKEN_TTL));
        $refreshToken = $user->createToken('refresh_token', [Constant::CAN_ISSUE_ACCESS_TOKEN], now()->addSeconds(Constant::REFRESH_TOKEN_TTL));

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function refreshToken(Request $request): array
    {
        $accessToken = $request->user()->createToken('access_token', [Constant::CAN_ACCESS_API], now()->addSeconds(Constant::ACCESS_TOKEN_TTL));

        return [
            'access_token' => $accessToken->plainTextToken
        ];
    }
}
