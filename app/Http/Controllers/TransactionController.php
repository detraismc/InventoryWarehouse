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
    /**
     * Display all transactions that are not completed.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch transactions where stage is not 'completed'
        $transactionList = Transaction::where('stage', '!=', 'completed')->get();

        if ($transactionList->isNotEmpty()) {
            return view('inventory.transaction', compact('transactionList'));
        }

        // Show a "no transaction" page if all transactions are completed
        return view('inventory.transaction_notransaction');
    }

    /**
     * Display all completed transactions.
     *
     * @return \Illuminate\View\View
     */
    public function indexCompleted()
    {
        // Fetch only completed transactions
        $transactionList = Transaction::where('stage', 'completed')->get();

        if ($transactionList->isNotEmpty()) {
            return view('inventory.transaction_completed', compact('transactionList'));
        }

        // Show "no transaction" page if none completed
        return view('inventory.transaction_notransaction');
    }

    /**
     * Update the stage of a transaction and handle stock changes.
     *
     * @param Request $request
     * @param string $id Transaction ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStage(Request $request, string $id)
    {
        // Validate incoming stage input
        $validated = $request->validate([
            'stage' => 'required|in:pending,packaging,shipment,completed',
        ]);

        // Fetch transaction with related transaction items and items
        $transaction = Transaction::with('getTransactionItem.getItem')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Update the transaction stage
            $transaction->update([
                'stage' => $validated['stage'],
            ]);

            // Handle stock adjustments only when transaction is completed
            if ($validated['stage'] === 'completed') {
                if ($transaction->type === 'supply') {
                    // Increase stock quantity for supply transactions
                    foreach ($transaction->getTransactionItem as $tItem) {
                        $item = $tItem->getItem;
                        if ($item) {
                            $item->increment('quantity', $tItem->quantity);
                        }
                    }
                } elseif ($transaction->type === 'transport') {
                    // Move stock to target warehouse for transport transactions
                    foreach ($transaction->getTransactionItem as $tItem) {
                        $sourceItem = $tItem->getItem;

                        $targetItem = Item::where('warehouse_id', $transaction->warehouse_target)
                            ->where('sku', $sourceItem->sku)
                            ->first();

                        $targetItem->increment('quantity', $tItem->quantity);
                    }
                }
            }

            // Prepare dynamic success messages per stage
            $stageMessages = [
                'pending'   => "Transaction {$id}# has been set to Pending.",
                'packaging' => "Transaction {$id}# is now in Packaging stage.",
                'shipment'  => "Transaction {$id}# is now in Shipment stage.",
                'completed' => "Transaction {$id}# completed successfully.",
            ];

            // Store transaction stage change in user logs
            UserLog::create([
                'sender' => Auth::user()->name,
                'log_type' => 'transaction',
                'log'    => "Advancing Transaction Stage: {$stageMessages[$validated['stage']]}",
            ]);

            DB::commit();

            return redirect()->route('inventory.transaction')
                ->with('success', $stageMessages[$validated['stage']] ?? 'Transaction stage updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update stage failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a transaction and its related transaction items.
     *
     * @param string $id Transaction ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find the transaction or fail
        $transaction = Transaction::findOrFail($id);

        // Delete all associated transaction items
        $transaction->getTransactionItem()->delete();

        // Delete the transaction itself
        $transaction->delete();

        // Store deletion action in user log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'transaction',
            'log'    => "Deleted Transaction: {$id}#",
        ]);

        // Redirect back to completed transactions page
        return redirect()->route('inventory.transaction.completed')->with('success', 'Transaction berhasil didelete');
    }
}
