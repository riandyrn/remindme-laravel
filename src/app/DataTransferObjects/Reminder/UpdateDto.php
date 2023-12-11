<?php

namespace App\DataTransferObjects\Reminder;

use App\Http\Requests\Api\Reminder\UpdateRequest as ApiUpdateRequest;

class UpdateDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $remind_at,
        public readonly string $event_at,
    )
    {
        //
    }

    public static function fromApiRequest(ApiUpdateRequest $request): UpdateDto
    {
        return new self(
            id: $request->route('id'),
            title: $request->validated(key: 'title'),
            description: $request->validated(key: 'description'),
            remind_at: $request->validated(key: 'remind_at'),
            event_at: $request->validated(key: 'event_at'),
        );
    }
}
