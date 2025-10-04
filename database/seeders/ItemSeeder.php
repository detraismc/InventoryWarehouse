<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Electronics
            [
                'category_id' => 1,
                'warehouse_id' => 1,
                'quantity' => 50,
                'name' => 'Laptop',
                'description' => 'High-performance laptop',
                'sku' => 'ELEC-LAP-001',
                'standard_supply_cost' => 800,
                'standard_sell_price' => 1000,
                'reorder_level' => 10
            ],
            [
                'category_id' => 1,
                'warehouse_id' => 1,
                'quantity' => 100,
                'name' => 'Smartphone',
                'description' => 'Latest generation smartphone',
                'sku' => 'ELEC-PHONE-001',
                'standard_supply_cost' => 400,
                'standard_sell_price' => 600,
                'reorder_level' => 20
            ],
            [
                'category_id' => 1,
                'warehouse_id' => 2,
                'quantity' => 30,
                'name' => 'Headphones',
                'description' => 'Wireless noise-cancelling headphones',
                'sku' => 'ELEC-HEAD-001',
                'standard_supply_cost' => 50,
                'standard_sell_price' => 100,
                'reorder_level' => 5
            ],

            // Furniture
            [
                'category_id' => 2,
                'warehouse_id' => 2,
                'quantity' => 20,
                'name' => 'Office Chair',
                'description' => 'Ergonomic chair for office use',
                'sku' => 'FURN-CHAIR-001',
                'standard_supply_cost' => 50,
                'standard_sell_price' => 100,
                'reorder_level' => 5
            ],
            [
                'category_id' => 2,
                'warehouse_id' => 1,
                'quantity' => 15,
                'name' => 'Wooden Desk',
                'description' => 'Sturdy wooden office desk',
                'sku' => 'FURN-DESK-001',
                'standard_supply_cost' => 120,
                'standard_sell_price' => 200,
                'reorder_level' => 3
            ],
            [
                'category_id' => 2,
                'warehouse_id' => 2,
                'quantity' => 10,
                'name' => 'Bookshelf',
                'description' => '5-tier wooden bookshelf',
                'sku' => 'FURN-SHELF-001',
                'standard_supply_cost' => 70,
                'standard_sell_price' => 150,
                'reorder_level' => 2
            ],

            // Groceries
            [
                'category_id' => 3,
                'warehouse_id' => 1,
                'quantity' => 200,
                'name' => 'Rice (5kg)',
                'description' => 'Premium white rice, 5kg pack',
                'sku' => 'GROC-RICE-5KG',
                'standard_supply_cost' => 5,
                'standard_sell_price' => 10,
                'reorder_level' => 50
            ],
            [
                'category_id' => 3,
                'warehouse_id' => 1,
                'quantity' => 150,
                'name' => 'Cooking Oil (1L)',
                'description' => 'Sunflower cooking oil',
                'sku' => 'GROC-OIL-1L',
                'standard_supply_cost' => 2,
                'standard_sell_price' => 4,
                'reorder_level' => 30
            ],
            [
                'category_id' => 3,
                'warehouse_id' => 2,
                'quantity' => 300,
                'name' => 'Instant Noodles',
                'description' => 'Pack of 10 instant noodles',
                'sku' => 'GROC-NOOD-10',
                'standard_supply_cost' => 3,
                'standard_sell_price' => 6,
                'reorder_level' => 40
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
