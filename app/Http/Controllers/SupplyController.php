<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemData;
use App\Models\Warehouse;

class SupplyController extends Controller
{
    public function index()
    {
        $warehouseList = Warehouse::all();

        if ($warehouseList->isNotEmpty()) {
            return redirect()->route('inventory.supply.show', $warehouseList->first()->id);
        }

        return view('inventory.supply_nowarehouse');
    }

    public function show(Warehouse $warehouse)
    {
        $warehouseList = Warehouse::all();

        // Only get items for this warehouse
        $itemDataList = ItemData::with('item_data')
            ->where('warehouse_id', $warehouse->id)
            ->get();

        return view('inventory.supply', compact('warehouseList', 'itemDataList', 'warehouse'));
    }
}
