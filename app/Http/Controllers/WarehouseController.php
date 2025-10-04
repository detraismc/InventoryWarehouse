<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a list of warehouses with the total quantity of items per warehouse.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all warehouses and sum the quantity of related items
        $warehouseList = Warehouse::withSum('getItem', 'quantity')->get();

        // Pass the list to the view
        return view('inventory.warehouse', compact('warehouseList'));
    }

    /**
     * Create a new warehouse.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        // Create the warehouse
        $warehouse = Warehouse::create($validated);

        // Log the creation action
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Created warehouse: {$warehouse->name}"
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil ditambahkan');
    }

    /**
     * Update an existing warehouse.
     *
     * @param Request $request
     * @param string $id Warehouse ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
            'address' => 'required|string|max:255'
        ]);

        // Find warehouse to update
        $warehouse = Warehouse::findOrFail($id);

        // Store old name for logging
        $warehouseOldName = $warehouse->name;

        // Update warehouse details
        $warehouse->update($validated);

        // Store new name for logging
        $warehouseNewName = $warehouse->name;

        // Log the update action
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Updated warehouse: {$warehouseOldName} -> {$warehouseNewName}"
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Category berhasil di edit');
    }

    /**
     * Delete a warehouse and all associated items.
     *
     * @param string $id Warehouse ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find the warehouse to delete
        $warehouse = Warehouse::findOrFail($id);
        $warehouseName = $warehouse->name;

        // Delete all items associated with this warehouse
        $warehouse->getItem()->delete();

        // Delete the warehouse itself
        $warehouse->delete();

        // Log the deletion
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Deleted warehouse: {$warehouseName}"
        ]);

        return redirect()->route('inventory.warehouse')->with('success', 'Warehouse berhasil didelete');
    }
}
