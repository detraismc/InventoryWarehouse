<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function index()
    {
        // Only get transactions that are NOT completed
        $transactionList = Transaction::where('stage', '!=', 'completed')->get();

        if ($transactionList->isNotEmpty()) {
            return view('inventory.transaction', compact('transactionList'));
        }

        // If all are completed, show "no transaction" page
        return view('inventory.transaction_notransaction');
    }


    public function indexCompleted()
    {
        // ✅ Only fetch completed transactions
        $transactionList = Transaction::where('stage', 'completed')->get();

        if ($transactionList->isNotEmpty()) {
            return view('inventory.transaction_completed', compact('transactionList'));
        }

        // ✅ No completed transactions at all
        return view('inventory.transaction_notransaction');
    }



    public function updateStage(Request $request, string $id)
    {
        $validated = $request->validate([
            'stage' => 'required|in:pending,packaging,shipment,completed',
        ]);

        $transaction = Transaction::with('getTransactionItem.getItem')->findOrFail($id);

        DB::beginTransaction();
        try {
            // ✅ Update stage
            $transaction->update([
                'stage' => $validated['stage'],
            ]);

            // ✅ Handle stock changes only when completed
            if ($validated['stage'] === 'completed') {
                if ($transaction->type === 'supply') {
                    foreach ($transaction->getTransactionItem as $tItem) {
                        $item = $tItem->getItem;
                        if ($item) {
                            $item->increment('quantity', $tItem->quantity);
                        }
                    }
                } elseif ($transaction->type === 'transport') {
                    foreach ($transaction->getTransactionItem as $tItem) {
                        $sourceItem = $tItem->getItem;

                        $targetItem = Item::where('warehouse_id', $transaction->warehouse_target)
                            ->where('name_id', $sourceItem->name_id)
                            ->first();

                        if ($targetItem) {
                            $targetItem->increment('quantity', $tItem->quantity);
                        } else {
                            Item::create([
                                'category_id'          => $sourceItem->category_id,
                                'warehouse_id'         => $transaction->warehouse_target,
                                'name_id'              => $sourceItem->name_id,
                                'name'                 => $sourceItem->name,
                                'description'          => $sourceItem->description,
                                'sku'                  => $sourceItem->sku,
                                'quantity'             => $tItem->quantity,
                                'standard_supply_cost' => $sourceItem->standard_supply_cost,
                                'standard_sell_price'  => $sourceItem->standard_sell_price,
                                'reorder_level'        => $sourceItem->reorder_level,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            // ✅ Dynamic success message
            $stageMessages = [
                'pending'   => 'Transaction ' + $validated['id'] + '# has been set to Pending.',
                'packaging' => 'Transaction ' + $validated['id'] + '# is now in Packaging stage.',
                'shipment'  => 'Transaction ' + $validated['id'] + '# is now in Shipment stage.',
                'completed' => 'Transaction ' + $validated['id'] + '# completed successfully.',
            ];

            return redirect()->route('inventory.transaction')
                ->with('success', $stageMessages[$validated['stage']] ?? 'Transaction stage updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update stage failed: ' . $e->getMessage()]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        #Delete semua transaction item
        $transaction->transaction_item()->delete();

        #Delete semua transaction log
        $transaction->transaction_log()->delete();

        #Delete warehouse
        $transaction->delete();
        return redirect()->route('inventory.transaction')->with('success', 'Transaction berhasil didelete');
    }
}
