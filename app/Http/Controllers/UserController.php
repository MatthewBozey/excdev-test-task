<?php

namespace App\Http\Controllers;

use App\Service\UserService;

class UserController extends MainController
{
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }


}
