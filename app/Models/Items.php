<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';
    protected $fillable = ['warehouse_id', 'category_id', 'name', 'sku', 'quantity', 'price', 'reorder_level'];
}
