<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function balance(): HasOne
    {
        return $this->hasOne(UserBalance::class);
    }

    public function balance_operation(): HasMany
    {
        return $this->hasMany(BalanceOperation::class)
            ->orderBy('operation_date', 'desc')
            ->limit(5);
    }

    public function getBalanceOperationGroupAttribute()
    {
        return \DB::table('balance_operation', 'bo')
            ->where('bo.user_id', $this->id)
            ->leftJoin('operation_type as ot', 'ot.id', '=', 'bo.operation_type_id')
            ->selectRaw('ot.title as name, COUNT(bo.id) as count')
            ->groupBy('ot.title')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'count' => $item->count,
                ];
            });
    }
}
