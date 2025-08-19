<?php

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

uses(TestCase::class);

function ensureProductTables(): void
{
    // categories
    if (!Schema::hasTable('categories')) {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable();
            $table->timestamps();
        });
    }

    // products
    if (!Schema::hasTable('products')) {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->json('colors')->nullable();
            $table->json('sizes')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['draft', 'active', 'archived'])->default('active');
            $table->timestamps();
        });
    }

    // images
    if (!Schema::hasTable('images')) {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->string('path');
            $table->timestamps();
        });
    }
}

beforeEach(function () {
    ensureProductTables();
});

it('casts colors and sizes as arrays', function () {
    $category = Category::create(['name' => 'Sneakers']);

    $product = Product::create([
        'name' => 'Air Zoom',
        'category_id' => $category->id,
        'description' => 'Comfortable running shoes',
        'price' => 129.99,
        'sku' => 'SKU-TEST-0001',
        'slug' => 'air-zoom',
        'colors' => ['white', 'black'],
        'sizes' => ['8', '9', '10'],
    ]);

    expect($product->colors)->toBeArray()->and($product->colors)->toEqual(['white', 'black']);
    expect($product->sizes)->toBeArray()->and($product->sizes)->toEqual(['8', '9', '10']);
});

it('belongs to a category', function () {
    $category = Category::create(['name' => 'Boots']);

    $product = Product::create([
        'name' => 'Trail Boot',
        'category_id' => $category->id,
        'price' => 99.50,
        'sku' => 'SKU-TEST-0002',
        'slug' => 'trail-boot',
    ]);

    $loaded = $product->load('category');

    expect($loaded->category)->toBeInstanceOf(Category::class)
        ->and($loaded->category->id)->toBe($category->id);
});

it('has many images', function () {
    $category = Category::create(['name' => 'Lifestyle']);

    $product = Product::create([
        'name' => 'City Walk',
        'category_id' => $category->id,
        'price' => 79.00,
        'sku' => 'SKU-TEST-0003',
        'slug' => 'city-walk',
    ]);

    $product->images()->create(['path' => 'products/city-walk-1.jpg']);
    $product->images()->create(['path' => 'products/city-walk-2.jpg']);

    $product->load('images');

    expect($product->images)->toHaveCount(2)
        ->and($product->images->first())->toBeInstanceOf(Image::class);
});

it('enforces unique sku and slug at the database level', function () {
    $category = Category::create(['name' => 'Running']);

    Product::create([
        'name' => 'Speed Runner',
        'category_id' => $category->id,
        'price' => 110.00,
        'sku' => 'SKU-UNIQ-0001',
        'slug' => 'speed-runner',
    ]);

    expect(function () use ($category) {
        Product::create([
            'name' => 'Speed Runner 2',
            'category_id' => $category->id,
            'price' => 120.00,
            'sku' => 'SKU-UNIQ-0001', // duplicate
            'slug' => 'speed-runner-2',
        ]);
    })->toThrow(QueryException::class);

    expect(function () use ($category) {
        Product::create([
            'name' => 'Speed Runner 3',
            'category_id' => $category->id,
            'price' => 130.00,
            'sku' => 'SKU-UNIQ-0002',
            'slug' => 'speed-runner', // duplicate
        ]);
    })->toThrow(QueryException::class);
});
