<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $categoryList = Category::all();
        return view('inventory.category', compact('categoryList'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
        ]);
        Category::create($validated);
        return redirect()->route('inventory.category')->with('success', 'Category berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
        ]);
        Category::where('id', $id)->update($validated);
        return redirect()->route('inventory.category')->with('success', 'Category berhasil di edit');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('inventory.category')->with('success', 'Category berhasil didelete');
    }
}
