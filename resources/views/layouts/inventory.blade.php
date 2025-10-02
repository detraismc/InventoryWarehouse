<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #e9ebf3;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: #f8f9fc;
            padding: 20px;
        }

        .sidebar h6 {
            color: #999;
            font-size: 12px;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            color: #555;
            text-decoration: none;
            margin-bottom: 5px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 500;
        }

        .navbar {
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #eee;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }



        .btn-custom {
            border-radius: 8px;
            font-size: 14px;
            padding: 6px 14px;
        }

        .btn-add {
            background-color: #4f46e5;
            color: #fff;
        }

        .btn-add:hover {
            background-color: #4338ca;
            color: #fff;
        }

        .btn-edit {
            background-color: #ffda47;
            color: #111;
        }

        .btn-edit:hover {
            background-color: #ecbb28;
            color: #111;
        }

        .btn-edit-password {
            background-color: #f8b271;
            color: #111;
        }

        .btn-edit-password:hover {
            background-color: #ef7d44;
            color: #111;
        }

        .btn-delete {
            background-color: #f87171;
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #ef4444;
            color: #fff;
        }



        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }


        .badge-pending {
            background-color: #ff6e6e;
            /* orange */
            color: #fff;
        }

        .badge-packaging {
            background-color: #3498db;
            /* blue */
            color: #fff;
        }

        .badge-shipment {
            background-color: #f1c40f;
            /* yellow */
            color: #000;
        }

        .badge-completed {
            background-color: #2ecc71;
            /* green */
            color: #fff;
        }




        .nav-tabs {
            border-bottom: 2px solid #e5e7eb;
        }

        .nav-tabs .nav-link {
            color: #9c9bb9;
            font-weight: 600;
            border: none;
            border-bottom: 3px solid transparent;
            border-radius: 0;
            padding: .75rem 1.25rem;
        }

        .nav-tabs .nav-link.active {
            color: #4f46e5;
            font-weight: 600;
            border-bottom: 3px solid #4f46e5;
            background: transparent;
        }



        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background-color: #4f46e5;
            border-color: #6c757d;
            color: #fff;
        }

        .dataTables_wrapper .dataTables_paginate .page-link {
            color: #495057;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        @include('partials.sidebar')


        <div class="flex-grow-1">
            <div class="container-fluid p-4">
                <h5 class="mb-4">@yield('title', 'Inventory')</h5>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                pageLength: 10
            });
        });

        function formatRupiah(value) {
            return value.replace(/\D/g, "") // keep only numbers
                .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // add dot separator
        }

        // Format live input
        document.querySelectorAll('.rupiah-format').forEach(function(input) {
            input.addEventListener('input', function() {
                this.value = formatRupiah(this.value);
            });
        });
    </script>
</body>

</html>
