<?php

namespace App\DataTransferObjects\Reminder;

use App\Http\Requests\Api\Reminder\CreateRequest as ApiCreateRequest;

class CreateDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $remind_at,
        public readonly string $event_at,
        public readonly string $token,
    )
    {
        //
    }

    public static function fromApiRequest(ApiCreateRequest $request): CreateDto
    {
        return new self(
            title: $request->validated(key: 'title'),
            description: $request->validated(key: 'description'),
            remind_at: $request->validated(key: 'remind_at'),
            event_at: $request->validated(key: 'event_at'),
            token: $request->bearerToken(),
        );
    }
}
