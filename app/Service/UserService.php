<?php

namespace App\Service;

use App\Facades\ApiSuccess;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = User::class;
        $this->storeRequest = UserCreateRequest::class;
        $this->updateRequest = UserUpdateRequest::class;
        $this->relations = ['balance'];
    }

    public function getBalance(Request $request): \App\Http\Response\ApiSuccessResponse
    {
        $user = auth()->user();

        return ApiSuccess::withData(
            $user
                ->load([
                    'balance',
                    'balance_operation',
                    'balance_operation.operationType',
                ])
                ->append(['balance_operation_group'])
        );
    }
}
