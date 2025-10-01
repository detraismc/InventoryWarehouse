<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = [
        'warehouse_id',

        'entity',
        'type',
        'stage',
        'warehouse_target',
        'transport_fee',
        'notes'
    ];

    public function getTransactionItem()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    public function getWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function getWarehouseTarget()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_target');
    }

}

