<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = User::pluck('id');

        foreach (range(1, 20) as $i) {
            Order::query()->create([
                'orders.description' => $faker->name,
                'orders.status' => $faker->randomElement(['pending', 'completed','processing', 'cancelled']),
                'orders.user_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
