<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';
    protected $fillable = ['name', 'sku', 'category_id', 'quantity', 'price', 'reorder_level'];
}
