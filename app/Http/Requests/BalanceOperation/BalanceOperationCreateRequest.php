<?php

namespace App\Http\Requests\BalanceOperation;

use App\Http\Requests\Main\FailedValidationHandleRequest;

class BalanceOperationCreateRequest extends FailedValidationHandleRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min: 1'],
            'operation_type_id' => ['required', 'integer', 'exists:operation_type,id'],
            'description' => ['required', 'string', ''],
        ];
    }
}
