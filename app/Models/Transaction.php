<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = ['user_id', 'item_id', 'transaction_type', 'quantity', 'date', 'notes'];
}
