<?php

namespace App\DataTransferObjects\Auth;

use App\Http\Requests\Api\Auth\LoginRequest as ApiLoginRequest;

class LoginDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    )
    {
        //
    }

    public static function fromApiRequest(ApiLoginRequest $request): LoginDto
    {
        return new self(
            email: $request->validated(key: 'email'),
            password: $request->validated(key: 'password'),
        );
    }
}
