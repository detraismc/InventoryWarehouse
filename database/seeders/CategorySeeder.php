<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories'
        ]);

        Category::create([
            'name' => 'Furniture',
            'description' => 'Home and office furniture'
        ]);

        Category::create([
            'name' => 'Groceries',
            'description' => 'Daily needs and food products'
        ]);
    }
}
