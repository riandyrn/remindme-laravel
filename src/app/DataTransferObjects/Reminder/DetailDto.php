<?php

namespace App\DataTransferObjects\Reminder;

use Illuminate\Http\Request;

class DetailDto
{
    public function __construct(
        public readonly string $id
    )
    {
        //
    }

    public static function fromApiRequest(Request $request): DetailDto
    {
        return new self(
            id: $request->route('id')
        );
    }
}
