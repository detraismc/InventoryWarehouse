<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemData extends Model
{
    protected $table = 'item_data';
    protected $fillable = [
        'item_id',
        'warehouse_id',

        'quantity',
        'sku',
        'standard_supply_cost',
        'standard_sell_price',
        'reorder_level'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
