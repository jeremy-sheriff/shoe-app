<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $i) {
            Product::query()->create([
                'name'        => $faker->words(3, true),
                'description' => $faker->sentence(12),
                'price'       => $faker->randomFloat(2, 10, 500),
                'stock'       => $faker->numberBetween(0, 100),
                'sku'         => strtoupper(Str::random(8)),
                'image_path'  => 'products/sample.jpg', // use a default or random image if available
                'is_active'   => $faker->boolean(90), // 90% chance of true
                'status'      => $faker->randomElement(['draft', 'active', 'archived']),
            ]);
        }
    }
}

