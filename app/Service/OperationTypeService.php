<?php

namespace App\Service;

use App\Models\OperationType;

class OperationTypeService extends BaseService
{
    public function __construct()
    {
        $this->model = OperationType::class;
    }
}
