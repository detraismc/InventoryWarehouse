@extends('layouts.inventory')

@section('title', 'Warehouse')

@section('content')

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Address</th>
                        <th>Accumulated Items</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($warehouseList as $warehouse)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->description }}</td>
                            <td>{{ $warehouse->address }}</td>
                            <td>0</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-custom btn-edit me-2" data-bs-toggle="modal"
                                    data-bs-target="#editWarehouseModal" data-id="{{ $warehouse->id }}"
                                    data-name="{{ $warehouse->name }}" data-description="{{ $warehouse->description }}"
                                    data-address="{{ $warehouse->address }}">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="#" class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">+ Add
            Warehouse</a>
    </div>



    <!-- Add Warehouse Modal -->
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-labelledby="addWarehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addWarehouseModalLabel">Add Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('inventory.warehouse.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="WarehouseName" class="form-label">Warehouse Name</label>
                            <input type="text" class="form-control" id="WarehouseName" name="name"
                                placeholder="Enter Warehouse name" required>
                        </div>
                        <div class="mb-3">
                            <label for="WarehouseDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="WarehouseDescription" name="description"
                                placeholder="Enter Address" required>
                        </div>
                        <div class="mb-3">
                            <label for="WarehouseAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="WarehouseAddress" name="address"
                                placeholder="Enter Address" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Create Warehouse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Warehouse Modal -->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-labelledby="editWarehouseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="editWarehouseModalLabel">Edit Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWarehouseForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editWarehouseName" class="form-label">Warehouse Name</label>
                            <input type="text" class="form-control" id="editWarehouseName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editWarehouseDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editWarehouseDescription" name="description"
                                placeholder="Enter Description">
                        </div>
                        <div class="mb-3">
                            <label for="editWarehouseAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editWarehouseAddress" name="address"
                                placeholder="Enter Address">
                        </div>
                    </div>

                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-custom btn-delete">Delete</button>
                    </form>
                    <button type="submit" class="btn btn-custom btn-add btn-sm" form="editWarehouseForm">Update
                        Warehouse</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = document.getElementById('editWarehouseModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var description = button.getAttribute('data-description') || '';
                var address = button.getAttribute('data-address') || '';

                // Fill fields
                editModal.querySelector('#editWarehouseName').value = name;
                editModal.querySelector('#editWarehouseDescription').value = description;
                editModal.querySelector('#editWarehouseAddress').value = address;

                // Update form action
                var form = document.getElementById('editWarehouseForm');
                form.action = "/warehouse/" + id;

                // Delete form action
                var deleteForm = document.getElementById('deleteForm');
                deleteForm.action = "/warehouse/" + id;
            });
        });
    </script>

@endsection
