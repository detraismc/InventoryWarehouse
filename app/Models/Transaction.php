<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = [
        'warehouse_id',

        'entity',
        'type',
        'stage',
        'transport_fee',
        'notes'
    ];

    public function transaction_item()
    {
        return $this->hasMany(Items::class, 'transaction_id');
    }

    public function transaction_log()
    {
        return $this->hasMany(TransactionLog::class, 'transaction_id');
    }
}

