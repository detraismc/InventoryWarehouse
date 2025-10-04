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
    /**
     * Display the list of items along with categories and warehouses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all items with related category and warehouse data
        $itemList = Item::with(['category', 'warehouse'])->get();

        // Get all categories for dropdown/select
        $categoryList = Category::all();

        // Get all warehouses for dropdown/select
        $warehouseList = Warehouse::all();

        // Return the inventory.item view with the data
        return view('inventory.item', compact('itemList', 'categoryList', 'warehouseList'));
    }

    /**
     * Store a new item in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'warehouse_id' => 'required|integer|min:1',
            'category_id' => 'required|integer|min:1',
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'quantity' => 'required|integer|min:0',
            'sku' => [
                'required',
                'min:3',
                // SKU must be unique per warehouse
                Rule::unique('item')->where(fn ($query) =>
                    $query->where('warehouse_id', $request->warehouse_id)
                ),
            ],
            'standard_supply_cost' => 'required',
            'standard_sell_price' => 'required',
            'reorder_level' => 'nullable|integer|min:-1'
        ]);

        // Remove dots from Rupiah formatted numbers
        $validated['standard_supply_cost'] = (int) str_replace('.', '', $request->standard_supply_cost);
        $validated['standard_sell_price']  = (int) str_replace('.', '', $request->standard_sell_price);

        // Create the new item
        Item::create($validated);

        // Log this action
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Created item: {$request->name}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'Item berhasil ditambahkan');
    }

    /**
     * Duplicate an existing item to another warehouse.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:item,id',
            'warehouse_id' => 'required|integer|exists:warehouse,id',
        ]);

        // Get the original item
        $originalItem = Item::findOrFail($validated['item_id']);

        // Get the target warehouse
        $targetWarehouse = Warehouse::findOrFail($validated['warehouse_id']);

        // Prevent duplicating to the same warehouse
        if ($originalItem->warehouse_id == $validated['warehouse_id']) {
            return back()->withErrors([
                "Cant be duplicate on the same warehouse."
            ]);
        }

        // Duplicate item for the new warehouse and reset quantity to 0
        $newItem = $originalItem->replicate();
        $newItem->warehouse_id = $validated['warehouse_id'];
        $newItem->quantity = 0;
        $newItem->save();

        // Log duplication action
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Duplicated item: {$originalItem->name} to warehouse {$targetWarehouse->name}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'Item berhasil diduplikasi ke gudang lain');
    }

    /**
     * Update an existing item in the database.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming request data
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

        // Remove dots from Rupiah formatted numbers
        $validated['standard_supply_cost'] = str_replace('.', '', $request->standard_supply_cost);
        $validated['standard_sell_price']   = str_replace('.', '', $request->standard_sell_price);

        // Find the item and update it
        $item = Item::findOrFail($id);
        $itemOldName = $item->name;
        $item->update($validated);
        $itemNewName = $item->name;

        // Log the update
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Updated item: {$itemOldName} -> {$itemNewName}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'Item berhasil di edit');
    }

    /**
     * Delete an item from the database.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find and delete the item
        $item = Item::findOrFail($id);
        $itemName = $item->name;
        $item->delete();

        // Log the deletion
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Deleted item: {$itemName}"
        ]);

        return redirect()->route('inventory.item')->with('success', 'Item berhasil didelete');
    }
}
