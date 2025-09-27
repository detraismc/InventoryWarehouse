<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Items;

class Warehouse extends Model
{
    protected $table = 'warehouse';
    protected $fillable = [
        'name',
        'description',
        'location'
    ];

    public function items()
    {
        return $this->hasMany(Items::class, 'warehouse_id');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'warehouse_id');
    }
}
