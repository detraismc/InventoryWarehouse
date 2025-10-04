<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = [
            // Supply
            [
                'warehouse_id' => 1,
                'entity' => 'Supplier A',
                'type' => 'supply',
                'stage' => 'completed',
                'warehouse_target' => null,
                'transport_fee' => 50,
                'notes' => 'Electronics supply from Supplier A'
            ],
            [
                'warehouse_id' => 2,
                'entity' => 'Supplier B',
                'type' => 'supply',
                'stage' => 'completed',
                'warehouse_target' => null,
                'transport_fee' => 30,
                'notes' => 'Furniture supply from Supplier B'
            ],
            [
                'warehouse_id' => 1,
                'entity' => 'Supplier C',
                'type' => 'supply',
                'stage' => 'completed',
                'warehouse_target' => null,
                'transport_fee' => 40,
                'notes' => 'Groceries supply from Supplier C'
            ],

            // Sell
            [
                'warehouse_id' => 1,
                'entity' => 'Customer X',
                'type' => 'sell',
                'stage' => 'completed',
                'warehouse_target' => null,
                'transport_fee' => 20,
                'notes' => 'Sold electronics to Customer X'
            ],
            [
                'warehouse_id' => 2,
                'entity' => 'Customer Y',
                'type' => 'sell',
                'stage' => 'completed',
                'warehouse_target' => null,
                'transport_fee' => 15,
                'notes' => 'Sold furniture to Customer Y'
            ],
            [
                'warehouse_id' => 1,
                'entity' => 'Customer Z',
                'type' => 'sell',
                'stage' => 'completed',
                'warehouse_target' => null,
                'transport_fee' => 10,
                'notes' => 'Sold groceries to Customer Z'
            ],

            // Transport
            [
                'warehouse_id' => 1,
                'entity' => 'Stock Transfer',
                'type' => 'transport',
                'stage' => 'completed',
                'warehouse_target' => 2,
                'transport_fee' => 25,
                'notes' => 'Transferred laptops and smartphones to East Warehouse'
            ],
            [
                'warehouse_id' => 2,
                'entity' => 'Stock Transfer',
                'type' => 'transport',
                'stage' => 'completed',
                'warehouse_target' => 1,
                'transport_fee' => 18,
                'notes' => 'Transferred furniture back to Central Warehouse'
            ],
        ];

        foreach ($transactions as $trx) {
            Transaction::create($trx);
        }
    }
}
