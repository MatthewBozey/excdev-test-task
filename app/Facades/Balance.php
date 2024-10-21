<?php

namespace App\Facades;

use App\Events\BalanceChanged;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Facade;

/**
 * @see UserBalance
 */
class Balance extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'balance';
    }

    public static function getUserInfo(int $userId)
    {
        return BalanceChanged::dispatch(\App\Models\User::find($userId)
            ->load([
                'balance',
                'balance_operation',
                'balance_operation.operationType',
            ])
            ->append(['balance_operation_group']));
    }
}
