<?php

namespace App\DataTransferObjects\Reminder;

use Illuminate\Http\Request;

class DeleteDto
{
    public function __construct(
        public readonly string $id
    )
    {
        //
    }

    public static function fromApiRequest(Request $request): DeleteDto
    {
        return new self(
            id: $request->route('id')
        );
    }
}
