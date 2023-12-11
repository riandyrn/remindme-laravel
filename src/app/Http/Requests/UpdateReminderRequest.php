<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'nullable', 'string'
            ],
            'description' => [
                'nullable', 'string'
            ],
            'remind_at' => [
                'nullable', 'integer', 'numeric'
            ],
            'event_at' => [
                'nullable', 'integer', 'numeric'
            ],
        ];
    }
}
