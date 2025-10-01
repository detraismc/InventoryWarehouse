<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $table = 'transaction_item';
    protected $fillable = [
        'transaction_id',
        'item_id',

        'quantity',
        'revenue',
        'cost'
    ];

    public function getTransaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function getItem()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
