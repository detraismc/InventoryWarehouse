<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemData;

class Warehouse extends Model
{
    protected $table = 'warehouse';
    protected $fillable = [
        'name',
        'description',
        'address'
    ];

    public function getItemData()
    {
        return $this->hasMany(ItemData::class, 'warehouse_id');
    }
    public function getTransaction()
    {
        return $this->hasMany(Transaction::class, 'warehouse_id');
    }
}
