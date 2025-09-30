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
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addSupplyModal">
                        Add Supply
                    </button>

                    <!-- Sell Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#sellSupplyModal">
                        Sell Supply
                    </button>

                    <!-- Transport Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#transportSupplyModal">
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




    <!-- Add Supply Modal -->
    <div class="modal fade" id="addSupplyModal" tabindex="-1" aria-labelledby="addSupplyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addSupplyModalLabel">Add Supply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Item Dropdown -->
                        <div class="mb-3">
                            <label for="Item" class="form-label">Item</label>
                            <select class="form-select" id="Item" name="item_id" required>
                                <option value="">-- Select Item --</option>
                                @foreach ($itemList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity + Cost -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="Quantity" name="quantity" placeholder="Qty"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="Cost" class="form-label">Cost per Item</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control rupiah-format" id="Cost" name="cost"
                                        placeholder="Enter Cost" required>
                                </div>
                            </div>
                        </div>

                        <!-- Transport Fee -->
                        <div class="mb-3">
                            <label for="TransportFee" class="form-label">Transport Fee</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" id="TransportFee"
                                    name="transport_fee" placeholder="Enter Transport Fee">
                            </div>
                        </div>


                        <!-- Entity -->
                        <div class="mb-3">
                            <label for="Entity" class="form-label">Entity</label>
                            <input type="text" class="form-control" id="Entity" name="entity"
                                placeholder="Enter Entity">
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="Notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="Notes" name="notes" rows="2" placeholder="Enter Notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Create Supply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <!-- Sell Supply Modal -->
    <div class="modal fade" id="sellSupplyModal" tabindex="-1" aria-labelledby="sellSupplyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="sellSupplyModalLabel">Sell Supply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Item Dropdown -->
                        <div class="mb-3">
                            <label for="Item" class="form-label">Item</label>
                            <select class="form-select" id="Item" name="item_id" required>
                                <option value="">-- Select Item --</option>
                                @foreach ($itemList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity + Revenue -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="Quantity" name="quantity"
                                    placeholder="Qty" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="Revenue" class="form-label">Revenue per Item</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control rupiah-format" id="Revenue"
                                        name="revenue" placeholder="Enter Revenue" required>
                                </div>
                            </div>
                        </div>

                        <!-- Transport Fee -->
                        <div class="mb-3">
                            <label for="TransportFee" class="form-label">Transport Fee</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" id="TransportFee"
                                    name="transport_fee" placeholder="Enter Transport Fee">
                            </div>
                        </div>

                        <!-- Entity -->
                        <div class="mb-3">
                            <label for="Entity" class="form-label">Entity</label>
                            <input type="text" class="form-control" id="Entity" name="entity"
                                placeholder="Enter Entity">
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="Notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="Notes" name="notes" rows="2" placeholder="Enter Notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Sell Supply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Transport Supply Modal -->
    <div class="modal fade" id="transportSupplyModal" tabindex="-1" aria-labelledby="transportSupplyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="transportSupplyModalLabel">Transport Supply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Item Dropdown -->
                        <div class="mb-3">
                            <label for="Item" class="form-label">Item</label>
                            <select class="form-select" id="Item" name="item_id" required>
                                <option value="">-- Select Item --</option>
                                @foreach ($itemList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity + Transport Fee -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="Quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="Quantity" name="quantity"
                                    placeholder="Qty" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="TransportFee" class="form-label">Transport Fee</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control rupiah-format" id="TransportFee"
                                        name="transport_fee" placeholder="Enter Transport Fee">
                                </div>
                            </div>
                        </div>

                        <!-- Warehouse -->
                        <div class="mb-3">
                            <label for="Warehouse" class="form-label">Warehouse</label>
                            <input type="text" class="form-control" id="Warehouse" name="warehouse"
                                placeholder="Enter Warehouse">
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="Notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="Notes" name="notes" rows="2" placeholder="Enter Notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Transport Supply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





@endsection
