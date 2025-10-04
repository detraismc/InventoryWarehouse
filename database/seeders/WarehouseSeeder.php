<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Central Warehouse',
            'description' => 'Main distribution hub',
            'address' => '123 Main St'
        ]);

        Warehouse::create([
            'name' => 'East Warehouse',
            'description' => 'East region storage',
            'address' => '456 East Rd'
        ]);
    }
}
