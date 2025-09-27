<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'warehouse_id',
        'category_id',

        'name',
        'sku',
        'standard_supply_cost',
        'standard_sell_price',
        'quantity',
        'reorder_level'
    ];
}
