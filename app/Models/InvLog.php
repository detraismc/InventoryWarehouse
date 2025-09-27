<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'inv_log';
    protected $fillable = ['warehouse_id', 'user_id', 'item_id', 'transaction_type', 'quantity', 'date', 'notes'];
}
