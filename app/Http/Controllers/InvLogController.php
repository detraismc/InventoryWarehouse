<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvLog;

class InvLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $InvLogList = InvLog::all();
        return view('inventory.InvLog', compact('InvLogList'));
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
            'InvLog_type' => 'required|in:IN,OUT',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date|before_or_equal:today'
        ]);
        InvLog::create($validated);
        return redirect()->route('inventory.InvLog')->with('success', 'InvLogs berhasil ditambahkan');
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
        $InvLog = InvLog::findOrFail($id);
        $InvLog->delete();
        return redirect()->route('inventory.InvLog')->with('success', 'InvLog berhasil didelete');
    }
}
