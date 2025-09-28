<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouseList = Warehouse::all();
        return view('inventory.warehouse', compact('warehouseList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
            'address' => 'required|string|max:255'
        ]);
        Warehouse::create($validated);
        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
            'address' => 'required|string|max:255'
        ]);
        Warehouse::where('id', $id)->update($validated);
        return redirect()->route('inventory.warehouse')->with('success', 'Category berhasil di edit');
    }

    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        #Delete semua items
        $warehouse->itemData()->delete();

        #Delete warehouse
        $warehouse->delete();
        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil didelete');
    }
}
