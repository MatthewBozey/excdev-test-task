<?php

namespace App\Models;

use App\Observers\UserBalanceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([UserBalanceObserver::class])]
class UserBalance extends Model
{
    protected $table = 'user_balance';

    protected $fillable = [
        'user_id',
        'balance',
        'operation_type_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function operationType(): BelongsTo
    {
        return $this->belongsTo(OperationType::class);
    }
}
