<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReminderCollection extends ResourceCollection
{
    protected int $limit;

    public function __construct(mixed $resource, int $limit)
    {
        $this->limit = $limit;

        parent::__construct($resource);
    }

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = ReminderResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this->resource;
        return [
            'reminders' => $this->collection,
            'limit' => $this->limit
        ];
    }
}
