<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\Transaction;

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

        $itemList = Item::with(['category', 'warehouse'])
            ->where('warehouse_id', $warehouse->id)
            ->get();

        return view('inventory.supply', compact('warehouseList', 'itemList', 'warehouse'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'transaction_item' => 'required|array|min:1',
            'transaction_item.*.id' => 'required|integer',
            'transaction_item.*.quantity' => 'required|integer|min:1',
            'transaction_item.*.cost' => 'nullable|string',
            'transaction_item.*.revenue' => 'nullable|string',
            'warehouse_id' => 'required|integer',
            'warehouse_target' => 'required|integer',
            'entity' => 'nullable|string|max:255',
            'transport_fee' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        // Create main transaction
        $transaction = Transaction::create([
            'warehouse_id' => $request->warehouse_id,
            'warehouse_target' => $request->warehouse_id,
            'entity' => $request->entity ?: 'System',
            'type' => $request->transaction_type,
            'stage' => 'pending',
            'transport_fee' => str_replace('.', '', $request->transport_fee ?? '0'),
            'notes' => $request->notes,
        ]);


        // Loop through each item and create TransactionItem
        foreach ($request->transaction_item as $itemData) {
            $cost = !empty($itemData['cost']) ? str_replace('.', '', $itemData['cost']) : 0;
            $revenue = !empty($itemData['revenue']) ? str_replace('.', '', $itemData['revenue']) : 0;

            $transaction->getTransactionItem()->create([
                'item_id' => $itemData['id'],
                'quantity' => $itemData['quantity'],
                'cost' => (int) $cost,
                'revenue' => (int) $revenue,
            ]);
        }


        return redirect()->route('inventory.supply.show', ['warehouse' => $request->warehouse_id])
                 ->with('success', 'Supply berhasil ditambahkan.');
    }





}
