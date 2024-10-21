<?php

namespace App\Broadcasting;

use App\Models\User;

class BalanceChannel
{
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        //
    }
}
