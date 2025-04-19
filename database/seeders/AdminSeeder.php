<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Dr Morch',
            'email' => 'drmorch@gmail.com',
            'password' => Hash::make('gitpass2016'),
            'role' => 'admin',
        ]);
    }
}
