<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionLog;

class TransactionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $TransactionLogList = TransactionLog::all();

        return view('inventory.log', compact('TransactionLogList'));
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
            'warehouse_id' => 'required|min:1',
            'user_id' => 'required|min:1',
            'item_id' => 'required|min:1',
            'TransactionLog_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date|before_or_equal:today',
        ]);
        TransactionLog::create($validated);

        return redirect()->route('inventory.log')->with('success', 'TransactionLogs berhasil ditambahkan');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $TransactionLog = TransactionLog::findOrFail($id);
        $TransactionLog->delete();

        return redirect()->route('inventory.log')->with('success', 'TransactionLog berhasil didelete');
    }
}
