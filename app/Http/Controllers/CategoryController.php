<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

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

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Created category: {$request->name}"
        ]);

        return redirect()->route('inventory.category')->with('success', 'Category berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $categoryOldName = $category->name;
        $category->update($validated);
        $categoryNewName = $category->name;

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Updated category: {$categoryOldName} -> {$categoryNewName}"
        ]);

        return redirect()->route('inventory.category')->with('success', 'Category berhasil di edit');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $categoryName = $category->name;
        $category->delete();

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Deleted category: {$categoryName}"
        ]);

        return redirect()->route('inventory.category')->with('success', 'Category berhasil didelete');
    }
}
