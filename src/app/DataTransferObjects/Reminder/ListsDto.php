<?php

namespace App\DataTransferObjects\Reminder;

use Illuminate\Http\Request;

class ListsDto
{
    public function __construct(
        public readonly string $limit
    )
    {
        //
    }

    public static function fromApiRequest(Request $request): ListsDto
    {
        return new self(
            limit: $request->exists('limit') ? $request->query('limit') : 10
        );
    }
}
