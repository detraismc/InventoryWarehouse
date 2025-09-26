<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouseList = Warehouse::all();
        return view('inventory.warehouse', compact('categoryList'));
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
            'name' => 'required|min:3',
        ]);
        Warehouse::create($validated);
        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil ditambahkan');
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
        $warehouseList = Warehouse::all();
        $warehouse = Warehouse::findOrFail($id);
        return view('inventory.warehouse', compact('warehouseList', 'warehouse'));
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
        $warehouse = Warehouse::findOrFail($id);

        #Delete semua items
        $warehouse->items()->delete();

        #Delete warehouse
        $warehouse->delete();
        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil didelete');
    }
}
