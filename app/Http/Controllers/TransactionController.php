<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;

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
                            ->where('sku', $sourceItem->sku)
                            ->first();

                        $targetItem->increment('quantity', $tItem->quantity);
                    }
                }
            }

            // ✅ Dynamic success message
            $stageMessages = [
                'pending'   => "Transaction {$id}# has been set to Pending.",
                'packaging' => "Transaction {$id}# is now in Packaging stage.",
                'shipment'  => "Transaction {$id}# is now in Shipment stage.",
                'completed' => "Transaction {$id}# completed successfully.",
            ];

            // Store log
            UserLog::create([
                'sender' => Auth::user()->name,
                'log_type' => 'transaction',
                'log'    => "Advancing Transaction Stage: {$stageMessages[$validated['stage']]}"
            ]);

            DB::commit();

            return redirect()->route('inventory.transaction')
                ->with('success', $stageMessages[$validated['stage']] ?? 'Transaction stage updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update stage failed: ' . $e->getMessage()]);
        }
    }




    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        #Delete semua transaction item
        $transaction->getTransactionItem()->delete();

        #Delete warehouse
        $transaction->delete();

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'transaction',
            'log'    => "Deleted Transaction: {$id}#"
        ]);

        return redirect()->route('inventory.transaction.completed')->with('success', 'Transaction berhasil didelete');
    }
}
