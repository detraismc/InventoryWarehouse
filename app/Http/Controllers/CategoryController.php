<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display list of all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        // Fetch all categories from database
        $categoryList = Category::all();

        // Pass categories to the view
        return view('inventory.category', compact('categoryList'));
    }

    /**
     * Store a new category.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        // Validate input:
        // - name is required and must be at least 3 characters
        // - description is optional but max length is 255
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
        ]);

        // Create new category
        Category::create($validated);

        // Store log for audit trail
        UserLog::create([
            'sender'   => Auth::user()->name,          // Current user name
            'log_type' => 'setup',                     // Type of log
            'log'      => "Created category: {$request->name}"
        ]);

        // Redirect back with success message
        return redirect()->route('inventory.category')->with('success', 'Category berhasil ditambahkan');
    }

    /**
     * Update an existing category.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        // Validate updated input
        $validated = $request->validate([
            'name' => 'required|min:3',
            'description' => 'nullable|string|max:255',
        ]);

        // Find category or fail with 404
        $category = Category::findOrFail($id);

        // Save old name for logging
        $categoryOldName = $category->name;

        // Update category with new values
        $category->update($validated);

        // New name after update
        $categoryNewName = $category->name;

        // Store log showing before -> after changes
        UserLog::create([
            'sender'   => Auth::user()->name,
            'log_type' => 'setup',
            'log'      => "Updated category: {$categoryOldName} -> {$categoryNewName}"
        ]);

        return redirect()->route('inventory.category')->with('success', 'Category berhasil di edit');
    }

    /**
     * Delete a category.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find category or fail with 404
        $category = Category::findOrFail($id);

        // Store category name before deleting
        $categoryName = $category->name;

        // Delete the category
        $category->delete();

        // Store log of deletion
        UserLog::create([
            'sender'   => Auth::user()->name,
            'log_type' => 'setup',
            'log'      => "Deleted category: {$categoryName}"
        ]);

        return redirect()->route('inventory.category')->with('success', 'Category berhasil didelete');
    }
}
