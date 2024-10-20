<?php

namespace App\Models;

use App\Traits\ModelFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceOperation extends Model
{
    use ModelFilter;

    protected $table = 'balance_operation';

    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'operation_date',
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

    protected function casts(): array
    {
        return [
            'operation_date' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
