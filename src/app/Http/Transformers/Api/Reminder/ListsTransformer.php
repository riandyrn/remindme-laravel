<?php

namespace App\Http\Transformers\Api\Reminder;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListsTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $data = [];
        foreach ($this->resource as $property) {
            $data['reminders'][] = [
                'id' => $property->id,
                'title' => $property->title,
                'description' => $property->description,
                'remind_at' => $property->remind_at,
                'event_at' => $property->event_at,
            ];
        }

        return $data;
    }
}
