<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateUserBalanceJob implements ShouldQueue
{
    use Queueable;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function fail($exception = null): void
    {
        \Log::error($exception);
    }

    public function handle(): void
    {
        UserBalance::updateOrCreate(['user_id' => $this->user->id], ['balance' => 0]);
    }
}
