<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('livewire.categories.index', [
            'categories' => Category::with('parent')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('livewire.categories.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        $category = Category::with('children')->findOrFail($id);

        return view('livewire.categories.show', [
            'category' => $category,
        ]);
    }

    public function showPub($id)
    {
        $category = Category::with('products')->findOrFail($id);

        return view('category.show', [
            'category' => $category,
            'products' => $category->products,
        ]);
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('livewire.categories.edit', [
            'category' => $category,
            'categories' => Category::where('id', '!=', $id)->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with subcategories.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
