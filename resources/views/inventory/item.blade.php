@extends('layouts.inventory')

@section('title', 'Item')

@section('content')

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemList as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-custom btn-edit me-2" data-bs-toggle="modal"
                                    data-bs-target="#editItemModal" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}" data-description="{{ $item->description }}"
                                    data-category="{{ $item->category->id }}">
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
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #eee;">
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

                        <div class="mb-3">
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

                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #eee;">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Create Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #eee;">
                    <h5 class="modal-title fw-semibold" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Delete button -->
                <form id="editItemForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="editItemName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editItemDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editItemDescription" name="description"
                                placeholder="Enter Description">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="editCategory" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categoryList as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </form>
                <div class="modal-footer d-flex justify-content-between" style="border-top: 1px solid #eee;">
                    <!-- Update button -->
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-custom btn-delete">Delete</button>
                    </form>
                    <button type="submit" class="btn btn-custom btn-add btn-sm" form="editItemForm">Update
                        Item</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = document.getElementById('editItemModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var description = button.getAttribute('data-description') || '';
                var category = button.getAttribute('data-category');

                // Fill fields
                editModal.querySelector('#editItemName').value = name;
                editModal.querySelector('#editItemDescription').value = description;
                editModal.querySelector('#editCategory').value = category;

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
