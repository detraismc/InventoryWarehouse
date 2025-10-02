@extends('layouts.inventory')

@section('title', 'Item')

@section('content')

    <div class="card p-3">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Warehouse</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemList as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->warehouse->name }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-custom btn-edit me-2" data-bs-toggle="modal"
                                    data-bs-target="#editItemModal" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" data-description="{{ $item->description }}"
                                    data-category="{{ $item->category->id }}"
                                    data-warehouse="{{ $item->warehouse->id ?? '' }}" data-quantity="{{ $item->quantity }}"
                                    data-supply-cost="{{ $item->standard_supply_cost }}"
                                    data-sell-price="{{ $item->standard_sell_price }}"
                                    data-reorder-level="{{ $item->reorder_level }}" data-sku="{{ $item->sku }}">
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
        <a href="#" class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addItemModal">+ Add
            Item</a>
    </div>



    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addItemModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('inventory.item.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="ItemName" name="name"
                                placeholder="Enter Item name" required>
                        </div>

                        <div class="mb-3">
                            <label for="ItemDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="ItemDescription" name="description"
                                placeholder="Enter Description" required>
                        </div>

                        <!-- Category + Warehouse side by side -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categoryList as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="warehouse_id" class="form-label">Warehouse</label>
                                <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                                    <option value="">-- Select Warehouse --</option>
                                    @foreach ($warehouseList as $warehouse)
                                        <option value="{{ $warehouse->id }}">
                                            {{ $warehouse->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity"
                                placeholder="Enter Quantity" required>
                        </div>

                        <!-- Standard Supply Cost -->
                        <div class="mb-3">
                            <label for="standard_supply_cost" class="form-label">Standard Supply Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" id="standard_supply_cost"
                                    name="standard_supply_cost" placeholder="Enter Supply Cost" required>
                            </div>
                        </div>

                        <!-- Standard Sell Cost -->
                        <div class="mb-3">
                            <label for="standard_sell_price" class="form-label">Standard Sell Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" id="standard_sell_price"
                                    name="standard_sell_price" placeholder="Enter Sell Cost" required>
                            </div>
                        </div>

                        <!-- Reorder Level + SKU in one row -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="reorder_level" class="form-label">Reorder Level</label>
                                <input type="number" class="form-control" id="reorder_level" name="reorder_level"
                                    placeholder="Enter Reorder Level" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku"
                                    placeholder="Enter SKU" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Create Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editItemForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <!-- Item Name -->

                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="editItemName" name="name" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="editItemDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editItemDescription" name="description"
                                placeholder="Enter Description" required>
                        </div>

                        <!-- Category + Warehouse -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editCategory" class="form-label">Category</label>
                                <select name="category_id" id="editCategory" class="form-select" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categoryList as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editWarehouse" class="form-label">Warehouse</label>
                                <select name="warehouse_id" id="editWarehouse" class="form-select" required>
                                    <option value="">-- Select Warehouse --</option>
                                    @foreach ($warehouseList as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="editQuantity" name="quantity"
                                placeholder="Enter Quantity" required>
                        </div>

                        <!-- Standard Supply Cost -->
                        <div class="mb-3">
                            <label for="editStandardSupplyCost" class="form-label">Standard Supply Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" id="editStandardSupplyCost"
                                    name="standard_supply_cost" placeholder="Enter Supply Cost" required>
                            </div>
                        </div>

                        <!-- Standard Sell Cost -->
                        <div class="mb-3">
                            <label for="editStandardSellPrice" class="form-label">Standard Sell Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" id="editStandardSellPrice"
                                    name="standard_sell_price" placeholder="Enter Sell Price" required>
                            </div>
                        </div>

                        <!-- Reorder Level + SKU -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editReorderLevel" class="form-label">Reorder Level</label>
                                <input type="number" class="form-control" id="editReorderLevel" name="reorder_level"
                                    placeholder="Enter Reorder Level" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editSKU" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="editSKU" name="sku"
                                    placeholder="Enter SKU" required>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="modal-footer d-flex justify-content-between">
                    <!-- Delete Form -->
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-custom btn-delete">Delete</button>
                    </form>

                    <!-- Update Button -->
                    <button type="submit" class="btn btn-custom btn-add btn-sm" form="editItemForm">Update Item</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = document.getElementById('editItemModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                // Get data from button
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var description = button.getAttribute('data-description') || '';
                var category = button.getAttribute('data-category');
                var warehouse = button.getAttribute('data-warehouse');
                var quantity = button.getAttribute('data-quantity');
                var sku = button.getAttribute('data-sku');
                var supplyCost = button.getAttribute('data-supply-cost');
                var sellPrice = button.getAttribute('data-sell-price');
                var reorderLevel = button.getAttribute('data-reorder-level');

                // Fill fields
                editModal.querySelector('#editItemName').value = name;
                editModal.querySelector('#editItemDescription').value = description;
                editModal.querySelector('#editCategory').value = category;
                editModal.querySelector('#editWarehouse').value = warehouse;
                editModal.querySelector('#editQuantity').value = quantity;
                editModal.querySelector('#editSKU').value = sku;
                editModal.querySelector('#editStandardSupplyCost').value = formatRupiah(supplyCost || '');
                editModal.querySelector('#editStandardSellPrice').value = formatRupiah(sellPrice || '');
                editModal.querySelector('#editReorderLevel').value = reorderLevel;

                // Update form action
                var form = document.getElementById('editItemForm');
                form.action = "/item/" + id;

                // Delete form action
                var deleteForm = document.getElementById('deleteForm');
                deleteForm.action = "/item/" + id;
            });
        });
    </script>




@endsection
