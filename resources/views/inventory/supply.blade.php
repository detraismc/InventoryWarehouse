@extends('layouts.inventory')

@section('title', 'Supply Overview')

@section('content')


    <div class="container py-1">
        <div class="card">
            <!-- Warehouse Tabs as Card Header -->
            <div class="card-header border-0 pb-1.2">
                <ul class="nav nav-tabs card-header-tabs">
                    @foreach ($warehouseList as $w)
                        <li class="nav-item">
                            <a href="{{ route('inventory.supply.show', $w->id) }}"
                                class="nav-link {{ isset($warehouse) && $warehouse->id == $w->id ? 'active' : '' }}">
                                {{ $w->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>


            </div>

            <!-- Tab Contents -->
            <div class="card-body">



                <div class="mb-4">
                    <span class="d-block text-muted fst-italic mb-2">
                        {{ $warehouse->description ?? 'No description available' }}
                    </span>
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="bi bi-geo-alt me-1 text-danger"></i>
                        {{ $warehouse->address }}
                    </span>
                </div>









                <h5 class="mb-1.5">Actions:</h5>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <!-- Add Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                        Add Supply
                    </button>

                    <!-- Sell Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                        Sell Supply
                    </button>

                    <!-- Transport Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                        Transport Supply
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="supplyTable" class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Reorder Level</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itemDataList as $itemData)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $itemData->item->name }}</td>
                                    <td>{{ $itemData->item->category }}</td>
                                    <td>{{ $itemData->quantity }}</td>
                                    <td>{{ $itemData->reorder_level }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('inventory.log.delete', ['id' => $log->id]) }}"
                                            id="deleteForm" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-custom btn-delete">X</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

@endsection
