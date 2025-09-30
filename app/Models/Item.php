<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $fillable = [
        'category_id',
        'warehouse_id',
        'quantity',

        'name',
        'description',
        'sku',
        'standard_supply_cost',
        'standard_sell_price',
        'reorder_level'
    ];

    public function category () {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
