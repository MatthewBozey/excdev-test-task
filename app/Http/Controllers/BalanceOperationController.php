<?php

namespace App\Http\Controllers;

use App\Helpers\BalanceOperationHelper;
use App\Http\Requests\BalanceOperation\BalanceOperationCreateRequest;
use App\Service\BalanceOperationService;

class BalanceOperationController extends MainController
{
    public function __construct(BalanceOperationService $service)
    {
        parent::__construct($service);
    }

    public function execOperation(BalanceOperationCreateRequest $request, BalanceOperationHelper $service)
    {
        return $this->service->execOperation($service, $request);
    }
}
