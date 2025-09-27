<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemsList = Items::all();
        return view('inventory.items', compact('itemsList'));
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
            'category_id' => 'required|min:1',

            'name' => 'required|min:3',
            'sku' => 'required|min:3',
            'standard_supply_cost' => 'required|integer|min:0',
            'standard_sell_price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0'
        ]);
        Items::create($validated);
        return redirect()->route('inventory.items')->with('success', 'Items berhasil ditambahkan');
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
        $itemsList = Items::all();
        $items = Items::findOrFail($id);
        return view('inventory.items', compact('itemsList', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|min:1',
            'category_id' => 'required|min:1',

            'name' => 'required|min:3',
            'sku' => 'required|min:3',
            'standard_supply_cost' => 'required|integer|min:0',
            'standard_sell_price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0'
        ]);
        Items::where('id', $id)->update($validated);
        return redirect()->route('inventory.items')->with('success', 'Items berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $items = Items::findOrFail($id);
        $items->delete();
        return redirect()->route('inventory.items')->with('success', 'Items berhasil didelete');
    }
}
