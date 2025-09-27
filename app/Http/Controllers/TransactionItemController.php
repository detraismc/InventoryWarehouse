<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionItemList = TransactionItem::all();
        return view('inventory.items', compact('transactionItemList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|min:1',
            'item_id' => 'required|min:1',

            'quantity' => 'required|integer|min:1',
            'revenue' => 'required|integer|min:0',
            'cost' => 'required|integer|min:0'
        ]);
        TransactionItem::create($validated);
        return redirect()->route('inventory.items')->with('success', 'Transaction Item berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionItem $transactionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionItem $transactionItem)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionItem $transactionItem)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionItem $transactionItem)
    {
        //
    }
}
