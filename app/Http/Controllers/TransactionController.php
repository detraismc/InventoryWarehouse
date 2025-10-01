<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $transactionList = Transaction::all();

        if ($transactionList->isNotEmpty()) {
            return view('inventory.transaction', compact('transactionList'));
        }

        return view('inventory.transaction_notransaction');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|min:1',

            'entity' => 'required|min:3',
            'type' => 'required|in:BUY,SELL,TRANSPORT',
            'stage' => 'required|in:PACKAGING,SHIPMENT,COMPLETED',
            'transport_fee' => 'required|integer|min:1'
        ]);
        Transaction::create($validated);

        return redirect()->route('inventory.transaction')->with('success', 'Transactions berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|min:1',

            'entity' => 'required|min:3',
            'type' => 'required|in:BUY,SELL,TRANSPORT',
            'stage' => 'required|in:PACKAGING,SHIPMENT,COMPLETED',
            'transport_fee' => 'required|integer|min:1'
        ]);
        Transaction::where('id', $id)->update($validated);
        return redirect()->route('inventory.transaction')->with('success', 'Transaction berhasil di edit');
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
