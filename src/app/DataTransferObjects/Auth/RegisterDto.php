<?php

namespace App\DataTransferObjects\Auth;

use App\Http\Requests\Api\Auth\RegisterRequest as ApiRegisterRequest;

class RegisterDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $confirm_password,
    )
    {
        //
    }

    public static function fromApiRequest(ApiRegisterRequest $request): RegisterDto
    {
        return new self(
            name: $request->validated(key: 'name'),
            email: $request->validated(key: 'email'),
            password: $request->validated(key: 'password'),
            confirm_password: $request->validated(key: 'confirm_password'),
        );
    }
}
