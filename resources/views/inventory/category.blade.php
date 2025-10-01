@extends('layouts.inventory')

@section('title', 'Category')

@section('content')

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoryList as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-custom btn-edit me-2" data-bs-toggle="modal"
                                    data-bs-target="#editCategoryModal" data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}" data-description="{{ $category->description }}">
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
        <a href="#" class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ Add
            Category</a>
    </div>



    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('inventory.category.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="CategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="CategoryName" name="name"
                                placeholder="Enter Category name" required>
                        </div>
                        <div class="mb-3">
                            <label for="CategoryDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="CategoryDescription" name="description"
                                placeholder="Enter Description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDescription" class="form-label">Description</label>
                            <input type="text" class="form-control" id="editCategoryDescription" name="description"
                                placeholder="Enter Description">
                        </div>
                    </div>

                </form>
                <div class="modal-footer d-flex justify-content-between">
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-custom btn-delete">Delete</button>
                    </form>
                    <button type="submit" class="btn btn-custom btn-add btn-sm" form="editCategoryForm">Update
                        Category</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = document.getElementById('editCategoryModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var description = button.getAttribute('data-description') || '';

                // Fill fields
                editModal.querySelector('#editCategoryName').value = name;
                editModal.querySelector('#editCategoryDescription').value = description;

                // Update form action
                var form = document.getElementById('editCategoryForm');
                form.action = "/category/" + id;

                // Delete form action
                var deleteForm = document.getElementById('deleteForm');
                deleteForm.action = "/category/" + id;
            });
        });
    </script>



@endsection
