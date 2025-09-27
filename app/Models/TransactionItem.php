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
}
