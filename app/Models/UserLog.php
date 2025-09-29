<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_log';
    protected $fillable = [
        'sender',
        'log_type',
        'log'
    ];
}
