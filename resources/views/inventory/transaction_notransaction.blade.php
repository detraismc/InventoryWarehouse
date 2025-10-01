@extends('layouts.inventory')

@section('title', 'Transaction')

@section('content')
    <div class="container py-3">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="text-center p-5 rounded-4 shadow-sm" style="background: #fff; max-width: 500px; width: 100%;">
                <div class="mb-4">
                    <img src="{{ asset('images/no_search.jpg') }}" alt="NoSearch" width="200" height="200">
                </div>

                <h3 class="fw-semibold mb-3" style="color: #333;">No Transaction Found</h3>
                <p class="text-muted mb-4">
                    You have no active transaction yet. You can add from the <strong>Supply Sidebar</strong>.
                </p>
                <a href="{{ route('inventory.supply') }}">
                    <button class="btn btn-custom btn-add">
                        Go to Supply
                    </button>
                </a>


            </div>
        </div>
    </div>
@endsection
