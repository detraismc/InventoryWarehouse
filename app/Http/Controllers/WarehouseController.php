<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\UserLog;

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
            'sender' => 'system',
            'log_type' => 'OTHER',
            'log'    => "Created warehouse: {$warehouse->name}",
            'date'   => now()
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
            'sender' => 'system',
            'log_type' => 'OTHER',
            'log'    => "Updated warehouse: {$warehouseOldName} -> {$warehouseNewName}",
            'date'   => now()
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Category berhasil di edit');
    }

    public function destroy(string $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        #Delete semua items
        #$warehouse->getItemData()->delete();

        #Delete warehouse
        $warehouse->delete();

        // Store log
        UserLog::create([
            'sender' => 'system',
            'log_type' => 'OTHER',
            'log'    => "Deleted warehouse: {$warehouse->name}",
            'date'   => now()
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil didelete');
    }
}
