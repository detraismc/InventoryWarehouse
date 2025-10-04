<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard with key metrics, recent transactions,
     * and financial summaries.
     */
    public function index()
    {
        /**
         * =====================
         * COUNTS / SUMMARY DATA
         * =====================
         * These are the main summary numbers displayed on the dashboard cards.
         */
        $itemsCount = Item::sum('quantity'); // Total quantity of all items
        $warehousesCount = Warehouse::count(); // Total number of warehouses
        $transactionsCount = Transaction::count(); // Total number of transactions
        $lowStockCount = Item::whereColumn('quantity', '<=', 'reorder_level')->count(); // Items that are below reorder level

        /**
         * =====================
         * RECENT TRANSACTIONS
         * =====================
         * Fetch the 5 most recent transactions with warehouse info.
         */
        $recentTransactions = Transaction::with('getWarehouse')
            ->latest() // Order by newest first
            ->take(5)  // Limit to 5 records
            ->get();

        /**
         * =====================
         * FINANCIAL DATA (Last 6 Months)
         * =====================
         * Aggregate revenue, cost, and profit per month.
         * Profit is calculated as revenue minus cost.
         */
        $financeData = TransactionItem::selectRaw("
                DATE_FORMAT(created_at, '%Y-%m') as month,
                SUM(revenue * quantity) as total_revenue,
                SUM(cost * quantity) as total_cost
            ")
            ->groupBy('month')      // Group data by month
            ->orderBy('month', 'asc') // Order chronologically
            ->take(6)               // Limit to last 6 months
            ->get();

        // Format months for display on charts (e.g., "Jan 2025")
        $months = $financeData->pluck('month')->map(function($m) {
            return Carbon::parse($m . '-01')->format('M Y');
        });

        // Extract revenue and cost data for charts
        $revenues = $financeData->pluck('total_revenue');
        $costs = $financeData->pluck('total_cost');

        // Calculate profit per month (Revenue - Cost)
        $profits = $revenues->map(function($rev, $key) use ($costs) {
            return $rev - $costs[$key];
        });

        // Calculate total revenue, cost, and profit for the last 6 months
        $totalRevenue = $revenues->sum();
        $totalCost = $costs->sum();
        $totalProfit = $profits->sum();

        /**
         * =====================
         * RETURN VIEW
         * =====================
         * Pass all the variables to the dashboard Blade view.
         */
        return view('inventory.dashboard', compact(
            'itemsCount',
            'warehousesCount',
            'transactionsCount',
            'lowStockCount',
            'recentTransactions',
            'months',
            'revenues',
            'profits',
            'totalRevenue',
            'totalCost',
            'totalProfit'
        ));
    }
}
