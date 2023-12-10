<?php

namespace App\Http\Transformers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'user' => [
                'id' => $this->id,
                'email' => $this->email,
                'name' => $this->name,
            ],
            'access_token' => $this->access_token,
        ];
    }
}
