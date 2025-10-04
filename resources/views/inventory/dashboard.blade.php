@extends('layouts.inventory')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-1">

        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <!-- Items Count -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Items</h6>
                        <h3 class="fw-bold">{{ $itemsCount }}</h3>
                    </div>
                </div>
            </div>

            <!-- Warehouses -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Warehouses</h6>
                        <h3 class="fw-bold">{{ $warehousesCount }}</h3>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Transactions</h6>
                        <h3 class="fw-bold">{{ $transactionsCount }}</h3>
                    </div>
                </div>
            </div>

            <!-- Low Stock -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Low Stock</h6>
                        <h3 class="fw-bold text-danger">{{ $lowStockCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue / Cost / Profit Row -->
        <div class="row g-4 mb-4">
            <!-- Revenue -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Revenue</h6>
                        <h3 class="fw-bold text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <small class="text-muted">(Last 6 Month)</small>
                    </div>
                </div>
            </div>

            <!-- Cost -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Cost</h6>
                        <h3 class="fw-bold text-secondary">Rp {{ number_format($totalCost, 0, ',', '.') }}</h3>
                        <small class="text-muted">(Last 6 Month)</small>
                    </div>
                </div>
            </div>

            <!-- Profit -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center">
                        <h6 class="fw-bold">Profit</h6>
                        <h3 class="fw-bold {{ $totalProfit < 0 ? 'text-danger' : 'text-success' }}">
                            Rp {{ number_format($totalProfit, 0, ',', '.') }}
                        </h3>
                        <small class="text-muted">(Last 6 Month)</small>
                    </div>
                </div>
            </div>
        </div>


        <!-- Chart -->
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Revenue & Profit (Last 6 Months)</h6>
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Warehouse</th>
                                <th>Type</th>
                                <th>Stage</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td class="ps-4">#{{ $transaction->id }}</td>
                                    <td>{{ $transaction->getWarehouse->name ?? '-' }}</td>
                                    <td><span
                                            class="badge @if ($transaction->type === 'supply') bg-primary
                        @elseif ($transaction->type === 'transport') bg-warning text-dark
                        @elseif ($transaction->type === 'sell') bg-success
                        @else bg-secondary @endif">{{ $transaction->type }}</span>
                                    </td>
                                    <td><span
                                            class="badge @if ($transaction->stage === 'pending') badge-pending
        @elseif ($transaction->stage === 'packaging') badge-packaging
        @elseif ($transaction->stage === 'shipment') badge-shipment
        @elseif ($transaction->stage === 'completed') badge-completed @endif">{{ $transaction->stage }}</span>
                                    </td>
                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No recent transactions</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'Revenue',
                        data: @json($revenues),
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79,70,229,0.1)',
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2,
                        pointBackgroundColor: '#4f46e5',
                        pointRadius: 4
                    },
                    {
                        label: 'Profit',
                        data: @json($profits),
                        borderColor: function(context) {
                            let value = context.raw;
                            return value >= 0 ? '#16a34a' : '#dc2626';
                        },
                        backgroundColor: function(context) {
                            let value = context.raw;
                            return value >= 0 ? 'rgba(22,163,74,0.1)' : 'rgba(220,38,38,0.1)';
                        },
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: function(context) {
                            let value = context.raw;
                            return value >= 0 ? '#16a34a' : '#dc2626';
                        }
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
