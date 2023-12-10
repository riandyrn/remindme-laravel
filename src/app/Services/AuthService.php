<?php

namespace App\Services;

use App\DataTransferObjects\Auth\RegisterDto;
use App\DataTransferObjects\Auth\LoginDto;
use App\Http\Transformers\Api\Auth\RegisterTransformer;
use App\Http\Transformers\Api\Auth\LoginTransformer;
use App\Repositories\UserRepository;
use App\Enums\TokenAbility;
use Auth;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterDto $dto)
    {
        $checkByEmail = $this->userRepository->findByEmail($dto->email);

        if ( $checkByEmail ) {
            return [
                'error_code' => 'ERR_REGISTER_CONFLICT_409',
                'message' => 'Email exists. choose another one.'
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
                'auth_token',
                [TokenAbility::ISSUE_ACCESS_TOKEN->value],
                now()->addDays(1)
            )->plainTextToken;

            return LoginTransformer::make($auth);

        } else {
            return [
                'error_code' => 'ERR_INVALID_CREDS_404',
                'message' => 'Email or password is wrong.'
            ];
        }
    }
}
