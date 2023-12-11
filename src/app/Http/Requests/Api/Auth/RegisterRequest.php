<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ApiFormatter;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            ApiFormatter::responseError(
                false,
                "ERR_VALIDATIONS_422",
                $errors,
                422
            )
        );
    }

    public function attributes(): array
    {
        return [
            'email' => 'email address',
        ];
    }
}
