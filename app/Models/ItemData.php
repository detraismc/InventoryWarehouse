<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemData extends Model
{
    protected $table = 'item';
    protected $fillable = [
        'item_id',
        'warehouse_id',

        'quantity',
        'sku',
        'standard_supply_cost',
        'standard_sell_price',
        'reorder_level'
    ];
}
