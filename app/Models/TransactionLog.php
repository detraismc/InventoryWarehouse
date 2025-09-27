<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $table = 'transaction_log';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'transaction_stage',
        'date'
    ];
}
