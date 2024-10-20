<?php

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait ModelFilter
{
    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}
