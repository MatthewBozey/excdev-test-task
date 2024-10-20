<?php

namespace App\Http\Requests\Main;

use App\Http\Response\ApiErrorResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FailedValidationHandleRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(new ApiErrorResponse('Произошла ошибка валидации', $validator->errors()->all(), 422));
    }
}
