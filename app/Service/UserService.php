<?php

namespace App\Service;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->model = User::class;
        $this->storeRequest = UserCreateRequest::class;
        $this->updateRequest = UserUpdateRequest::class;
        $this->relations = ['balance'];
    }


}
