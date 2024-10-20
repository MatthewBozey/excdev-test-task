<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends MainController
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    public function getBalance(Request $request)
    {
        return $this->service->getBalance($request);
    }
}
