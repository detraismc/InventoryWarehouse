<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionItem;

class TransactionItemSeeder extends Seeder
{
    public function run(): void
    {
        $transactionItems = [
            // Supply Transactions
            ['transaction_id' => 1, 'item_id' => 1, 'quantity' => 10, 'revenue' => 0, 'cost' => 2000000], // Laptops
            ['transaction_id' => 1, 'item_id' => 2, 'quantity' => 20, 'revenue' => 0, 'cost' => 2000000], // Smartphones
            ['transaction_id' => 2, 'item_id' => 4, 'quantity' => 15, 'revenue' => 0, 'cost' => 250000], // Chairs
            ['transaction_id' => 2, 'item_id' => 5, 'quantity' => 5, 'revenue' => 0, 'cost' => 150000],  // Desks
            ['transaction_id' => 3, 'item_id' => 7, 'quantity' => 50, 'revenue' => 0, 'cost' => 75000], // Rice
            ['transaction_id' => 3, 'item_id' => 8, 'quantity' => 40, 'revenue' => 0, 'cost' => 20000],  // Oil

            // Sell Transactions
            ['transaction_id' => 4, 'item_id' => 1, 'quantity' => 20, 'revenue' => 8000000, 'cost' => 0], // Laptops
            ['transaction_id' => 4, 'item_id' => 3, 'quantity' => 50, 'revenue' => 4000000, 'cost' => 0],   // Headphones
            ['transaction_id' => 5, 'item_id' => 4, 'quantity' => 20, 'revenue' => 800000, 'cost' => 0],   // Chairs
            ['transaction_id' => 5, 'item_id' => 6, 'quantity' => 10, 'revenue' => 600000, 'cost' => 0],    // Bookshelf
            ['transaction_id' => 6, 'item_id' => 7, 'quantity' => 100, 'revenue' => 400000, 'cost' => 0],   // Rice
            ['transaction_id' => 6, 'item_id' => 9, 'quantity' => 200, 'revenue' => 480000, 'cost' => 0],   // Noodles

            // Transport Transactions
            ['transaction_id' => 7, 'item_id' => 1, 'quantity' => 30, 'revenue' => 0, 'cost' => 0], // Laptops transfer
            ['transaction_id' => 7, 'item_id' => 2, 'quantity' => 50, 'revenue' => 0, 'cost' => 0], // Smartphones transfer
            ['transaction_id' => 8, 'item_id' => 4, 'quantity' => 20, 'revenue' => 0, 'cost' => 0], // Chairs transfer
            ['transaction_id' => 8, 'item_id' => 5, 'quantity' => 10, 'revenue' => 0, 'cost' => 0], // Desks transfer
        ];

        foreach ($transactionItems as $ti) {
            TransactionItem::create($ti);
        }
    }
}
