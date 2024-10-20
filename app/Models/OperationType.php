<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    const DEBIT = 'debit';

    const CREDIT = 'credit';

    protected $table = 'operation_type';

    protected $fillable = [
        'name',
        'title',
    ];
}
