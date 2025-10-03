<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class itemController extends Controller
{
    public function index()
    {
        $itemList = Item::with(['category', 'warehouse'])->get();
        $categoryList = Category::all();
        $warehouseList = Warehouse::all();
        return view('inventory.item', compact('itemList', 'categoryList', 'warehouseList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'quantity' => 'required|integer|min:0',
            'sku'          => [
                'required',
                'min:3',
                Rule::unique('item')->where(fn ($query) =>
                    $query->where('warehouse_id', $request->warehouse_id)
                ),
            ],
            'standard_supply_cost' => 'required',
            'standard_sell_price' => 'required',
            'reorder_level' => 'nullable|integer|min:-1'
        ]);

        // Clean Rupiah formatting (remove dots)
        $validated['standard_supply_cost'] = (int) str_replace('.', '', $request->standard_supply_cost);
        $validated['standard_sell_price']  = (int) str_replace('.', '', $request->standard_sell_price);
        Item::create($validated);

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Created item: {$request->name}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'item berhasil ditambahkan');
    }

    public function duplicate(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:item,id',
            'warehouse_id' => 'required|integer|exists:warehouse,id',
        ]);

        // Get the original item
        $originalItem = Item::findOrFail($validated['item_id']);

        // Get the target warehouse
        $targetWarehouse = Warehouse::findOrFail($validated['warehouse_id']);

        // Prevent duplication to the same warehouse
        if ($originalItem->warehouse_id == $validated['warehouse_id']) {
            return back()->withErrors([
                "Cant be duplicate on the same warehouse."
            ]);
        }

        // Duplicate item data for the new warehouse
        $newItem = $originalItem->replicate();
        $newItem->warehouse_id = $validated['warehouse_id'];
        $newItem->quantity = '0';
        $newItem->save();

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Duplicated item: {$originalItem->name} to warehouse {$targetWarehouse->name}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'Item berhasil diduplikasi ke gudang lain');
    }




    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'quantity' => 'required|integer|min:0',
            'sku' => 'required|min:3',
            'standard_supply_cost' => 'required',
            'standard_sell_price' => 'required',
            'reorder_level' => 'nullable|integer|min:-1'
        ]);

        // Clean Rupiah formatting (remove dots)
        $validated['standard_supply_cost'] = str_replace('.', '', $request->standard_supply_cost);
        $validated['standard_sell_price']   = str_replace('.', '', $request->standard_sell_price);

        $item = Item::findOrFail($id);
        $itemOldName = $item->name;
        $item->update($validated);
        $itemNewName = $item->name;

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Updated item: {$itemOldName} -> {$itemNewName}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'item berhasil di edit');
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $itemName = $item->name;
        $item->delete();

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Deleted item: {$itemName}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'item berhasil didelete');
    }

}
