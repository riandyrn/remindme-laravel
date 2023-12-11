<?php

namespace App\DataTransferObjects\Auth;

use Illuminate\Http\Request;

class RefreshTokenDto
{
    public function __construct(
        public readonly string $token
    )
    {
        //
    }

    public static function fromApiRequest(Request $request): RefreshTokenDto
    {
        return new self(
            token: $request->bearerToken()
        );
    }
}
