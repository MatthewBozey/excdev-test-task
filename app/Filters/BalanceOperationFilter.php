<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class BalanceOperationFilter extends QueryFilter
{
    public function operation_type_id($operationTypeId): Builder
    {
        return $this->builder->where('operation_type_id', $operationTypeId);
    }

    public function amount($amount): Builder
    {
        return $this->builder->where('amount', $amount);
    }

    public function description($description): Builder
    {
        return $this->builder->where('description', 'like', '%'.$description.'%');
    }

    public function operation_date($date): Builder
    {
        return $this->builder->whereDate('operation_date', $date);
    }
}
