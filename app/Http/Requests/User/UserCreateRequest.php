<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Main\FailedValidationHandleRequest;

class UserCreateRequest extends FailedValidationHandleRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:App\Models\User,email'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ];
    }
}
