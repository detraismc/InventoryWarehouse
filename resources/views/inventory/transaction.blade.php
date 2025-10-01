@extends('layouts.inventory')

@section('title', 'Transaction')

@section('content')
    <div class="container py-1">

        <div class="row g-3">
            @foreach ($transactionList as $transaction)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">

                        <!-- Transaction Type Strip -->
                        <div
                            class="d-flex justify-content-between align-items-center px-3 py-2 fw-semibold text-white rounded-top-4
                                @if ($transaction->type === 'supply') bg-primary
                                @elseif ($transaction->type === 'transport') bg-warning text-dark
                                @elseif ($transaction->type === 'sell') bg-success
                                @else bg-secondary @endif">
                            <p>{{ ucfirst($transaction->type) }}</p>
                            <p>#{{ $transaction->id }}</p>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <!-- Stage Badge + Date -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span
                                    class="badge
                                        @if ($transaction->stage === 'pending') bg-secondary
                                        @elseif ($transaction->stage === 'packaging') bg-info
                                        @elseif ($transaction->stage === 'shipment') bg-warning text-dark
                                        @elseif ($transaction->stage === 'completed') bg-success @endif">
                                    {{ ucfirst($transaction->stage) }}
                                </span>
                                <small class="text-muted">{{ $transaction->created_at->format('d M Y') }}</small>
                            </div>

                            <!-- Warehouse info -->
                            <p class="mb-2 text-muted small">
                                Warehouse: <strong>{{ $transaction->getWarehouse->name ?? '-' }}</strong><br>
                                @if ($transaction->type === 'transport' && $transaction->warehouse_target)
                                    Target: <strong>{{ $transaction->getWarehouseTarget->name ?? '-' }}</strong><br>
                                @endif
                            </p>

                            <!-- Items -->
                            <ul class="list-unstyled small flex-grow-1">
                                @foreach ($transaction->getTransactionItem as $ti)
                                    <li>• {{ $ti->getItem->name }} ({{ $ti->quantity }})</li>
                                @endforeach
                            </ul>

                            <!-- Footer -->
                            <div class="mt-auto pt-2">
                                @if ($transaction->type === 'supply')
                                    @php
                                        $totalCost = $transaction->getTransactionItem->sum(function ($ti) {
                                            return $ti->cost * $ti->quantity;
                                        });
                                    @endphp
                                    <p class="mb-1 small fw-semibold" style="color: red;">
                                        Total Cost: Rp{{ number_format($totalCost, 0, ',', '.') }}
                                    </p>
                                @elseif ($transaction->type === 'sell')
                                    @php
                                        $totalRevenue = $transaction->getTransactionItem->sum(function ($ti) {
                                            return $ti->revenue * $ti->quantity;
                                        });
                                    @endphp
                                    <p class="mb-1 small fw-semibold text-success">
                                        Total Revenue: Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                                    </p>
                                @endif

                                @if ($transaction->transport_fee)
                                    <p class="mb-1 small">Transport Fee:
                                        Rp{{ number_format($transaction->transport_fee, 0, ',', '.') }}
                                    </p>
                                @endif

                                <!-- Button to trigger modal -->
                                <button class="btn btn-custom btn-add mt-2 w-100" data-bs-toggle="modal"
                                    data-bs-target="#transactionModal{{ $transaction->id }}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Modal -->
                <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1"
                    aria-labelledby="transactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 border-0 shadow-sm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transactionModalLabel{{ $transaction->id }}">
                                    Transaction #{{ $transaction->id }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Type:</strong> {{ ucfirst($transaction->type) }}</p>
                                <p><strong>Stage:</strong> {{ ucfirst($transaction->stage) }}</p>
                                <p><strong>Warehouse:</strong> {{ $transaction->getWarehouse->name ?? '-' }}</p>
                                @if ($transaction->type === 'transport' && $transaction->warehouse_target)
                                    <p><strong>Target:</strong> {{ $transaction->getWarehouseTarget->name ?? '-' }}</p>
                                @endif
                                <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>

                                <hr>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Cost</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->getTransactionItem as $ti)
                                            <tr>
                                                <td>{{ $ti->getItem->name }}</td>
                                                <td>{{ $ti->quantity }}</td>
                                                <td>Rp{{ number_format($ti->cost ?? 0, 0, ',', '.') }}</td>
                                                <td>Rp{{ number_format($ti->revenue ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <!-- Advance stage form -->
                                @php
                                    $nextStage = match ($transaction->stage) {
                                        'pending' => 'packaging',
                                        'packaging' => 'shipment',
                                        'shipment' => 'completed',
                                        default => null,
                                    };
                                @endphp

                                @if ($nextStage)
                                    <form action="{{ route('inventory.transaction', $transaction->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="stage" value="{{ $nextStage }}">
                                        <button type="submit" class="btn btn-custom btn-add mt-2">
                                            Advance to {{ ucfirst($nextStage) }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
