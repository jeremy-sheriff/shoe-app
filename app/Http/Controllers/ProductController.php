<?php

namespace App\Http\Controllers;

use App\ExternalLibraries\Slim;
use App\Models\Category;
use App\Models\Product;
use App\Rules\HasThreeImages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $categories = Category::all();

        return view('livewire.products.index',
            compact('products',
                'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('livewire.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'slim' => ['required', new HasThreeImages()],
//
//            // Colors validation: ensure it's an array and each item is a valid color
//            'colors' => 'required|array',  // Ensure 'colors' is an array
//            'colors.*' => 'string|in:white,red,blue,green,yellow',  // Add more valid colors as needed

            // Sizes validation: ensure it's an array and each item is a valid size
            'sizes' => 'required|array',  // Ensure 'sizes' is an array
        ]);


        $slug = Str::slug($request->name);

        // Ensure it's unique by appending a number if needed
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $product = new Product([
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'slug' => $slug,
            'colors' => $request->colors, // auto-casts to JSON
            'sizes' => $request->sizes, // auto-casts to JSON
        ]);

        $product->sku = 'SKU-' . strtoupper(Str::random(8));

        $product->save();

        $images = Slim::getImages();

        foreach ($images as $image) {
            $name = $image['output']['name'];
            $data = $image['output']['data'];

            Slim::saveFile($data, $name);

            // Save to DB (example)
            $file = Slim::saveFile($data, $name);
            $product->images()->create([
                'path' => 'products/' . $file['name'],
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('livewire.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('livewire.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_one' => 'nullable|image',
            'image_two' => 'nullable|image',
            'image_three' => 'nullable|image',
        ]);

        $product->fill($request->only(['category_id', 'name', 'description', 'price']));

        foreach (['image_one', 'image_two', 'image_three'] as $field) {
            if ($request->hasFile($field)) {
                $product->{$field} = $request->file($field)->store('products', 'public');
            }
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
