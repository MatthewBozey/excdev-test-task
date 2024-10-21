<?php

namespace App\Observers;

use App\Events\BalanceChanged;
use App\Facades\Balance;
use App\Models\UserBalance;

class UserBalanceObserver
{
    public function created(UserBalance $userBalance): void {}

    public function updated(UserBalance $userBalance): void
    {
        BalanceChanged::dispatch(Balance::getUserInfo($userBalance->user_id));
    }

    public function deleted(UserBalance $userBalance): void {}

    public function restored(UserBalance $userBalance): void {}
}
