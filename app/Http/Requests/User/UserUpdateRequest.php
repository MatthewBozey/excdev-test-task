<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Main\FailedValidationHandleRequest;

class UserUpdateRequest extends FailedValidationHandleRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email,'.$this->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
