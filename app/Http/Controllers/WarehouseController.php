<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

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
        $warehouse = Warehouse::create($validated);

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Created warehouse: {$warehouse->name}"
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
            'address' => 'required|string|max:255'
        ]);
        $warehouse = Warehouse::findOrFail($id);
        $warehouseOldName = $warehouse->name;
        $warehouse->update($validated);
        $warehouseNewName = $warehouse->name;

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Updated warehouse: {$warehouseOldName} -> {$warehouseNewName}"
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Category berhasil di edit');
    }

    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouseName = $warehouse->name;

        #Delete semua items
        $warehouse->getItem()->delete();

        #Delete warehouse
        $warehouse->delete();

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Deleted warehouse: {$warehouseName}"
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil didelete');
    }
}
