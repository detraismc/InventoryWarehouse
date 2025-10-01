<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Warehouse;

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
            'sku' => 'required|min:3',
            'standard_supply_cost' => 'required',
            'standard_sell_price' => 'required',
            'reorder_level' => 'nullable|integer|min:-1'
        ]);

        // Clean Rupiah formatting (remove dots)
        $validated['standard_supply_cost'] = str_replace('.', '', $request->standard_supply_cost);
        $validated['standard_sell_price']   = str_replace('.', '', $request->standard_sell_price);
        Item::create($validated);
        return redirect()->route('inventory.item')->with('success', 'item berhasil ditambahkan');
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
        $validated['standard_supply_cost'] = str_replace('.', '', $request->standard_supply_cost);
        $validated['standard_sell_price']   = str_replace('.', '', $request->standard_sell_price);
        Item::where('id', $id)->update($validated);
        return redirect()->route('inventory.item')->with('success', 'item berhasil di edit');
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('inventory.item')->with('success', 'item berhasil didelete');
    }

}
