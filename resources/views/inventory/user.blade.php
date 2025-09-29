@extends('layouts.inventory')

@section('title', 'User')

@section('content')

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userList as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-custom btn-edit me-2" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal" data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}">
                                    Edit Profile
                                </a>
                                <a href="#" class="btn btn-sm btn-custom btn-edit-password me-2"
                                    data-bs-toggle="modal" data-bs-target="#editPasswordModal"
                                    data-id="{{ $user->id }}">
                                    Edit Password
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <a href="#" class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add
            User</a>
    </div>



    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #eee;">
                    <h5 class="modal-title fw-semibold" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('inventory.user.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="UserName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="UserName" name="name"
                                placeholder="Enter User Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="UserEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="UserEmail" name="email"
                                placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="UserPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="UserPassword" name="password"
                                placeholder="Enter Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="UserPasswordConfirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="UserPasswordConfirm"
                                name="password_confirmation" placeholder="Enter Confirm Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="UserRole" class="form-label">Role</label>
                            <select class="form-select" id="UserRole" name="role" required>
                                <option value="" disabled selected>-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #eee;">
                        <button type="submit" class="btn btn-custom btn-add btn-sm">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #eee;">
                    <h5 class="modal-title fw-semibold" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Delete button -->
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="editUserName" name="name"
                                placeholder="Enter User Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="editUserEmail" name="email"
                                placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">Role</label>
                            <select class="form-select" id="editUserRole" name="role" required>
                                <option value="" disabled selected>-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="user">User</option>
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
                    <button type="submit" class="btn btn-custom btn-add btn-sm" form="editUserForm">Update
                        User</button>
                </div>

            </div>
        </div>
    </div>



    <!-- Edit Password -->
    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #eee;">
                    <h5 class="modal-title fw-semibold" id="editPasswordModalLabel">Edit Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Delete button -->
                <form id="editPasswordForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password"
                                placeholder="Enter Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPasswordConfirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="editPasswordConfirm"
                                name="password_confirmation" placeholder="Enter Confirm Password" required>
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
                    <button type="submit" class="btn btn-custom btn-add btn-sm" form="editPasswordForm">Update
                        Password</button>
                </div>

            </div>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = document.getElementById('editUserModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var email = button.getAttribute('data-email') || '';
                var role = button.getAttribute('data-role');

                // Fill fields
                editModal.querySelector('#editUserName').value = name;
                editModal.querySelector('#editUserEmail').value = email;
                editModal.querySelector('#editUserRole').value = role;

                // Update form action
                var form = document.getElementById('editUserForm');
                form.action = "/user/" + id;

                // Delete form action
                var deleteForm = document.getElementById('deleteForm');
                deleteForm.action = "/user/" + id;
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var editModal = document.getElementById('editPasswordModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var form = document.getElementById('editPasswordForm');
                form.action = "/user/" + id + "/password";

                var deleteForm = document.getElementById('deleteForm');
                deleteForm.action = "/user/" + id;
            });
        });
    </script>



@endsection
