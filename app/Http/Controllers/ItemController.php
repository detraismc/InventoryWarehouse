<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class itemController extends Controller
{
    public function index()
    {
        $itemList = Item::with('category')->get();
        $categoryList = Category::all();
        return view('inventory.item', compact('itemList', 'categoryList'));
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|min:1',
            'name' => 'required|min:3',
            'description' => 'required|min:3',
        ]);
        Item::create($validated);
        return redirect()->route('inventory.item')->with('success', 'item berhasil ditambahkan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|min:1',
            'category_id' => 'required|min:1',

            'name' => 'required|min:3',
            'sku' => 'required|min:3',
            'standard_supply_cost' => 'required|integer|min:0',
            'standard_sell_price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:-1'
        ]);
        Item::create($validated);
        return redirect()->route('inventory.item')->with('success', 'item berhasil ditambahkan');
    }



    public function updateItem(Request $request, string $id)
    {
        $validated = $request->validate([
            'category_id' => 'required|min:1',
            'name' => 'required|min:3',
            'description' => 'required|min:3',
        ]);
        Item::where('id', $id)->update($validated);
        return redirect()->route('inventory.item')->with('success', 'item berhasil di edit');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|min:1',
            'category_id' => 'required|min:1',

            'name' => 'required|min:3',
            'sku' => 'required|min:3',
            'standard_supply_cost' => 'required|integer|min:0',
            'standard_sell_price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'reorder_level' => 'nullable|integer|min:-1'
        ]);
        Item::where('id', $id)->update($validated);
        return redirect()->route('inventory.item')->with('success', 'item berhasil di edit');
    }

    public function destroyItem(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('inventory.item')->with('success', 'item berhasil didelete');
    }

    public function destroyItemData(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('inventory.item')->with('success', 'item berhasil didelete');
    }
}
