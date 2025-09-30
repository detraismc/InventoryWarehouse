<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $fillable = [
        'category_id',

        'name',
        'description'
    ];

    public function category () {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function itemData()
    {
        return $this->hasMany(ItemData::class, 'item_id');
    }
}
