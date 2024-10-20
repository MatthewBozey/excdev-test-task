<?php

namespace App\Http\Controllers;

use App\Service\OperationTypeService;

class OperationTypeController extends MainController
{
    public function __construct(OperationTypeService $service)
    {
        parent::__construct($service);
    }
}
