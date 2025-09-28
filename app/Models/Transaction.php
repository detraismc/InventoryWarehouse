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

    public function getTransactionItem()
    {
        return $this->hasMany(ItemData::class, 'transaction_id');
    }

    public function getTransactionLog()
    {
        return $this->hasMany(TransactionLog::class, 'transaction_id');
    }
}

