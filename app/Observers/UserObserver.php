<?php

namespace App\Observers;

use App\Jobs\CreateUserBalanceJob;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        CreateUserBalanceJob::dispatch($user);
    }

    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
