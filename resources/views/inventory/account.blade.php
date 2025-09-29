@extends('layouts.inventory')

@section('title', 'Account')

@section('content')
    <div class="container py-1">
        <div class="row g-4">
            <!-- Edit Password Card -->
            <div class="col-md-4">
                <div class="card p-3 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white fw-semibold">Edit Password</div>
                    <div class="card-body">
                        <form action="{{ route('inventory.account.editpassword') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-custom btn-add mt-2">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Card -->
            <div class="col-md-4">
                <div class="card p-3 shadow-sm h-100" style="border-radius: 16px;">
                    <div class="card-header bg-white fw-semibold">Edit Profile</div>
                    <div class="card-body">
                        <form action="{{ route('inventory.account.editprofile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-custom btn-add mt-2">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Logout Card with User Info -->
            <div class="col-md-4">
                <div class="card p-3 shadow-sm" style="border-radius: 16px;">
                    <div class="card-header bg-white fw-semibold">My Account</div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="mb-3">
                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                @php
                                    $roleClass = match (Auth::user()->role) {
                                        'admin' => 'bg-danger',
                                        'manager' => 'bg-warning',
                                        'user' => 'bg-secondary',
                                        default => 'bg-dark',
                                    };
                                @endphp
                                <span class="badge text-capitalize {{ $roleClass }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>


                        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-custom btn-delete mt-2">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
