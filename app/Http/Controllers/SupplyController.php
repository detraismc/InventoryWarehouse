<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
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

        $itemDataList = Item::with('item')
            ->where('warehouse_id', $warehouse->id)
            ->get();

        $itemList = Item::all();
        return view('inventory.supply', compact('warehouseList', 'itemDataList', 'itemList', 'warehouse'));
    }
}
