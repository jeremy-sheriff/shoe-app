<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Parent categories
        $menId = Category::query()->create([
            'name' => 'Men Shoes',
            'parent_id' => null,
        ])->id;

        $womenId = Category::query()->create([
            'name' => 'Women Shoes',
            'parent_id' => null,
        ])->id;

        $sportsId = Category::query()->create([
            'name' => 'Sports Shoes',
            'parent_id' => null,
        ])->id;

        // Children categories
        Category::query()->create([
            'name' => 'Running Shoes',
            'parent_id' => $sportsId,
        ]);

        Category::query()->create([
            'name' => 'Basketball Shoes',
            'parent_id' => $sportsId,
        ]);

        Category::query()->create([
            'name' => 'Formal Shoes',
            'parent_id' => $menId,
        ]);

        Category::query()->create([
            'name' => 'Sneakers',
            'parent_id' => $menId,
        ]);

        Category::query()->create([
            'name' => 'Heels',
            'parent_id' => $womenId,
        ]);

        Category::query()->create([
            'name' => 'Flats',
            'parent_id' => $womenId,
        ]);

        Category::query()->create([
            'name' => 'Sandals',
            'parent_id' => $womenId,
        ]);
    }
}
