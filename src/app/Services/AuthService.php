<?php

namespace App\Services;

use App\DataTransferObjects\Auth\RegisterDto;
use App\DataTransferObjects\Auth\LoginDto;
use App\DataTransferObjects\Auth\RefreshTokenDto;
use App\Http\Transformers\Api\Auth\RegisterTransformer;
use App\Http\Transformers\Api\Auth\LoginTransformer;
use App\Http\Transformers\Api\Auth\RefreshTokenTransformer;
use App\Repositories\UserRepository;
use App\Repositories\PersonalAccessTokenRepository;
use App\Enums\TokenAbility;
use Auth;

class AuthService
{
    private $userRepository;
    private $personalAccessToken;

    public function __construct(
        UserRepository $userRepository,
        PersonalAccessTokenRepository $personalAccessTokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->personalAccessTokenRepository = $personalAccessTokenRepository;
    }

    public function register(RegisterDto $dto)
    {
        $checkByEmail = $this->userRepository->findByEmail($dto->email);

        if ( $checkByEmail ) {
            return [
                'error_code' => 'ERR_REGISTER_CONFLICT_409',
                'message' => 'Email exists. choose another one.',
                'status_code' => 409,
            ];
        }

        $register = $this->userRepository->save($dto);

        return  RegisterTransformer::make($register);
    }

    public function login(LoginDto $dto)
    {
        if (
            Auth::attempt([
                'email' => $dto->email,
                'password' => $dto->password
            ])
        ) {
            $auth = Auth::user();

            $auth['access_token'] = $auth->createToken(
                'auth_token',
                [TokenAbility::ACCESS_API->value],
                now()->addSeconds(20)
            )->plainTextToken;

            $auth['refresh_token'] = $auth->createToken(
                'refresh_token',
                [TokenAbility::ISSUE_ACCESS_TOKEN->value],
                now()->addDays(3)
            )->plainTextToken;

            return LoginTransformer::make($auth);

        } else {
            return [
                'error_code' => 'ERR_INVALID_CREDS_401',
                'message' => 'Email or password is wrong.',
                'status_code' => 401,
            ];
        }
    }

    public function refreshToken(RefreshTokenDto $dto)
    {
        $token = $this->personalAccessTokenRepository->findByToken($dto->token);
        $arr['access_token'] = $token->tokenable->createToken(
            'auth_token',
            [TokenAbility::ACCESS_API->value],
            now()->addSeconds(20)
        )->plainTextToken;

        $data = json_decode(json_encode($arr));

        return RefreshTokenTransformer::make($data);
    }
}
