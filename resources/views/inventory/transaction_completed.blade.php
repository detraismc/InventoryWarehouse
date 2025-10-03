@extends('layouts.inventory')

@section('title', 'Transactions')

@section('content')
    <div class="container py-1">

        <!-- ✅ Tab Navigation (same as index page) -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('inventory.transaction.index') ? 'active' : '' }}"
                    href="{{ route('inventory.transaction') }}">
                    Ongoing Transactions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('inventory.transaction.completed') ? 'active' : '' }}"
                    href="{{ route('inventory.transaction.completed') }}">
                    Completed Transactions
                </a>
            </li>
        </ul>

        <!-- ✅ DataTable -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Warehouse</th>
                            <th>Target</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total Cost</th>
                            <th>Total Revenue</th>
                            <th>Transport Fee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionList as $transaction)
                            <tr>
                                <td>#{{ $transaction->id }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->getWarehouse->name ?? '-' }}</td>
                                <td>
                                    @if ($transaction->type === 'transport' && $transaction->warehouse_target)
                                        {{ $transaction->getWarehouseTarget->name ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0 small">
                                        @foreach ($transaction->getTransactionItem as $ti)
                                            <li>{{ $ti->getItem->name ?? '-' }} ({{ $ti->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @php
                                        $totalCost = $transaction->getTransactionItem->sum(
                                            fn($ti) => ($ti->cost ?? 0) * $ti->quantity,
                                        );
                                    @endphp
                                    Rp{{ number_format($totalCost, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $totalRevenue = $transaction->getTransactionItem->sum(
                                            fn($ti) => ($ti->revenue ?? 0) * $ti->quantity,
                                        );
                                    @endphp
                                    Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($transaction->transport_fee)
                                        Rp{{ number_format($transaction->transport_fee, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (Auth::user() && Auth::user()->role === 'admin')
                                        <form
                                            action="{{ route('inventory.transaction.delete', ['id' => $transaction->id]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-custom btn-delete">X</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                pageLength: 10
            });
        });
    </script>
@endpush
