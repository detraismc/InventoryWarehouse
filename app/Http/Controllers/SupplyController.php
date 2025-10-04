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
    /**
     * Display the supply dashboard or redirect to the first warehouse.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        // Get all warehouses
        $warehouseList = Warehouse::all();

        // If there are warehouses, redirect to the first warehouse's supply page
        if ($warehouseList->isNotEmpty()) {
            return redirect()->route('inventory.supply.show', $warehouseList->first()->id);
        }

        // If no warehouses exist, show a "no warehouse" page
        return view('inventory.supply_nowarehouse');
    }

    /**
     * Show items for a specific warehouse.
     *
     * @param Warehouse $warehouse
     * @return \Illuminate\View\View
     */
    public function show(Warehouse $warehouse)
    {
        // Get all warehouses for dropdown
        $warehouseList = Warehouse::all();

        // Get all items for the selected warehouse including category and warehouse relations
        $itemList = Item::with(['category', 'warehouse'])
            ->where('warehouse_id', $warehouse->id)
            ->get();

        // Return the supply view with items and warehouse data
        return view('inventory.supply', compact('warehouseList', 'itemList', 'warehouse'));
    }

    /**
     * Store a new supply, sell, or transport transaction.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request
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

        // For transport transactions, ensure the target warehouse has the item model
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

        // For sell or transport, check if warehouse has enough quantity
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

        // Begin database transaction for atomicity
        DB::beginTransaction();

        try {
            // Create the main transaction record
            $transaction = Transaction::create([
                'warehouse_id'     => $request->warehouse_id,
                'warehouse_target' => $request->warehouse_target,
                'entity'           => $request->entity ?: 'System',
                'type'             => $request->transaction_type,
                'stage'            => 'pending',
                'transport_fee'    => str_replace('.', '', $request->transport_fee ?? '0'),
                'notes'            => $request->notes,
            ]);

            // Create transaction items and update stock accordingly
            foreach ($request->transaction_item as $itemData) {
                $cost    = !empty($itemData['cost']) ? str_replace('.', '', $itemData['cost']) : 0;
                $revenue = !empty($itemData['revenue']) ? str_replace('.', '', $itemData['revenue']) : 0;

                // Store item in the transaction
                $transaction->getTransactionItem()->create([
                    'item_id'  => $itemData['id'],
                    'quantity' => $itemData['quantity'],
                    'cost'     => (int) $cost,
                    'revenue'  => (int) $revenue,
                ]);

                // Update warehouse stock if transaction type is sell or transport
                $item = Item::findOrFail($itemData['id']);
                if (in_array($request->transaction_type, ['sell', 'transport'])) {
                    $item->decrement('quantity', $itemData['quantity']);
                }
            }

            // Store transaction action in user log
            UserLog::create([
                'sender' => Auth::user()->name,
                'log_type' => 'transaction',
                'log'    => "Transaction Added: {$request->id}#"
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('inventory.supply.show', ['warehouse' => $request->warehouse_id])
                ->with('success', 'Transaction berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Rollback on error
            DB::rollBack();
            return back()->withErrors(['error' => 'Transaction failed: ' . $e->getMessage()]);
        }
    }
}
