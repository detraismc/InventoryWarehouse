<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{


    public function index()
    {
        // Counts
        $itemsCount = \App\Models\Item::count();
        $warehousesCount = \App\Models\Warehouse::count();
        $transactionsCount = \App\Models\Transaction::count();
        $lowStockCount = \App\Models\Item::whereColumn('quantity', '<=', 'reorder_level')->count();

        // Recent transactions
        $recentTransactions = \App\Models\Transaction::with('getWarehouse')
            ->latest()
            ->take(5)
            ->get();

        // Warehouses
        $warehouses = \App\Models\Warehouse::with('getItem')->get();


        $subQuery = \App\Models\TransactionItem::select(
                'transaction_item.transaction_id',
                DB::raw("DATE_FORMAT(transaction_item.created_at, '%Y-%m') as month"),
                DB::raw("SUM(transaction_item.revenue * transaction_item.quantity) as revenue_sum"),
                DB::raw("SUM(transaction_item.cost * transaction_item.quantity) as cost_sum")
            )
            ->groupBy('transaction_item.transaction_id', 'month');

        $financeData = DB::table(DB::raw("({$subQuery->toSql()}) as ti"))
            ->mergeBindings($subQuery->getQuery())
            ->join('transaction', 'transaction.id', '=', 'ti.transaction_id')
            ->select(
                'ti.month',
                // revenue only from completed transactions
                DB::raw("SUM(CASE WHEN transaction.stage = 'completed' THEN ti.revenue_sum ELSE 0 END) as total_revenue"),
                // cost always included (+ transport_fee)
                DB::raw("SUM(ti.cost_sum + transaction.transport_fee) as total_cost"),
                // profit = revenue (completed only) - cost
                DB::raw("SUM(CASE WHEN transaction.stage = 'completed' THEN ti.revenue_sum ELSE 0 END) - SUM(ti.cost_sum + transaction.transport_fee) as total_profit")
            )
            ->groupBy('ti.month')
            ->orderBy('ti.month', 'asc')
            ->take(6)
            ->get();


        $months = $financeData->pluck('month')->map(function($m) {
            return \Carbon\Carbon::parse($m . '-01')->format('M Y');
        });

        $revenues = $financeData->pluck('total_revenue');
        $costs = $financeData->pluck('total_cost');
        $profits = $financeData->map(function ($row) {
            return $row->total_revenue - $row->total_cost;
        });

        // Totals
        $totalRevenue = $revenues->sum();
        $totalCost = $costs->sum();
        $totalProfit = $profits->sum();

        // Profit trends (week vs last week, month vs last month)
        $profitChangeWeek = 0;
        $profitChangeMonth = 0;

        $thisWeekProfit = \App\Models\TransactionItem::whereBetween('created_at', [
                now()->startOfWeek(), now()->endOfWeek()
            ])
            ->select(DB::raw("SUM(revenue - cost) as profit"))
            ->value('profit');

        $lastWeekProfit = \App\Models\TransactionItem::whereBetween('created_at', [
                now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()
            ])
            ->select(DB::raw("SUM(revenue - cost) as profit"))
            ->value('profit');

        if ($lastWeekProfit > 0) {
            $profitChangeWeek = round((($thisWeekProfit - $lastWeekProfit) / $lastWeekProfit) * 100, 2);
        }

        $thisMonthProfit = \App\Models\TransactionItem::whereBetween('created_at', [
                now()->startOfMonth(), now()->endOfMonth()
            ])
            ->select(DB::raw("SUM(revenue - cost) as profit"))
            ->value('profit');

        $lastMonthProfit = \App\Models\TransactionItem::whereBetween('created_at', [
                now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()
            ])
            ->select(DB::raw("SUM(revenue - cost) as profit"))
            ->value('profit');

        if ($lastMonthProfit > 0) {
            $profitChangeMonth = round((($thisMonthProfit - $lastMonthProfit) / $lastMonthProfit) * 100, 2);
        }

        return view('inventory.dashboard', compact(
            'itemsCount',
            'warehousesCount',
            'transactionsCount',
            'lowStockCount',
            'recentTransactions',
            'warehouses',
            'months',
            'revenues',
            'profits',
            'totalRevenue',
            'totalCost',
            'totalProfit',
            'profitChangeWeek',
            'profitChangeMonth'
        ));
    }




}
