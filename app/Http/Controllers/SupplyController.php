<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\Transaction;
use App\Models\UserLog;

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
            'transaction_item.*.id' => 'required|integer|exists:item,id',
            'transaction_item.*.quantity' => 'required|integer|min:1',
            'transaction_item.*.cost' => 'nullable|string',
            'transaction_item.*.revenue' => 'nullable|string',
            'warehouse_id' => 'required|integer|exists:warehouse,id',
            'warehouse_target' => 'required|integer|exists:warehouse,id',
            'entity' => 'nullable|string|max:255',
            'transaction_type' => 'required|in:supply,sell,transport',
            'transport_fee' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if warehouse_target has item model
        if ($request->transaction_type === 'transport') {
            $targetItem = Item::where('warehouse_id', $request->warehouse_target)
                        ->where('sku', $request->sku)
                        ->first();
            if (!$targetItem) {
                return back()->withErrors([
                    "There are no item model in that warehouse, create it first on Item Setup."
                ]);
            }
        }

        // Check if warehouse has item quantity
        if (in_array($request->transaction_type, ['sell', 'transport'])) {
            foreach ($request->transaction_item as $itemData) {
                $item = Item::findOrFail($itemData['id']);
                if ($item->quantity < $itemData['quantity']) {
                    return back()->withErrors([
                        "Item {$item->name} only has {$item->quantity} in stock, cannot fulfill {$itemData['quantity']}."
                    ]);
                }
            }
        }


        DB::beginTransaction();

        try {
            // create main transaction
            $transaction = Transaction::create([
                'warehouse_id'     => $request->warehouse_id,
                'warehouse_target' => $request->warehouse_target,
                'entity'           => $request->entity ?: 'System',
                'type'             => $request->transaction_type,
                'stage'            => 'pending',
                'transport_fee'    => str_replace('.', '', $request->transport_fee ?? '0'),
                'notes'            => $request->notes,
            ]);

            // create transaction items + update stock depending on type
            foreach ($request->transaction_item as $itemData) {
                $cost    = !empty($itemData['cost']) ? str_replace('.', '', $itemData['cost']) : 0;
                $revenue = !empty($itemData['revenue']) ? str_replace('.', '', $itemData['revenue']) : 0;

                $transaction->getTransactionItem()->create([
                    'item_id'  => $itemData['id'],
                    'quantity' => $itemData['quantity'],
                    'cost'     => (int) $cost,
                    'revenue'  => (int) $revenue,
                ]);

                $item = Item::findOrFail($itemData['id']);

                // Decrease quantity
                if (in_array($request->transaction_type, ['sell', 'transport'])) {
                    $item->decrement('quantity', $itemData['quantity']);
                }
            }

            // Store log
            UserLog::create([
                'sender' => Auth::user()->name,
                'log_type' => 'transaction',
                'log'    => "Transaction Added: {$request->id}#"
            ]);

            DB::commit();

            return redirect()->route('inventory.supply.show', ['warehouse' => $request->warehouse_id])
                ->with('success', 'Transaction berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaction failed: ' . $e->getMessage()]);
        }
    }









}
