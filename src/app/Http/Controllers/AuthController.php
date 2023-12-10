<?php

namespace App\Http\Controllers;

use App\Enums\TokenAbility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login to get access token.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            abort(401);
        }

        $userData = $user->setVisible(['id', 'email', 'name'])->toArray();
        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value],
            now()->addMinutes(config('sanctum.expiration'))
        );
        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbility::ISSUE_ACCESS_TOKEN->value],
            now()->addMinutes(config('sanctum.refresh_token_expiration'))
        );
        $responseData = [
            'ok' => true,
            'data' => [
                'user' => $userData,
                'access_token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken->plainTextToken,
            ],
        ];
        return response($responseData, 200);
    }
}
