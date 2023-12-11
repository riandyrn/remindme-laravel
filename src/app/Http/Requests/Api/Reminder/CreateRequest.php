<?php

namespace App\Http\Requests\Api\Reminder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiFormatter;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'remind_at' => ['required', 'integer'],
            'event_at' => ['required', 'integer'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            ApiFormatter::responseError(
                "ERR_VALIDATIONS_422",
                $errors,
                422
            )
        );
    }

    public function attributes(): array
    {
        return [
            'remind_at' => 'remind at',
            'event_at' => 'event at',
        ];
    }
}
