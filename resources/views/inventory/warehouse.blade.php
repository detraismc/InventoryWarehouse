<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e9ebf3;
      font-family: 'Inter', sans-serif;
    }
    /* Sidebar base */
    .sidebar {
      width: 230px;
      min-height: 100vh;
      background: #f8f9fc;
      padding: 20px;
      border-radius: 0 16px 16px 0;
      box-shadow: 2px 0 12px rgba(0,0,0,0.05);
    }
    .sidebar h4 {
      font-weight: 600;
      color: #111;
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
      transition: 0.2s;
    }
    .sidebar a.active, .sidebar a:hover {
      background: #eef2ff;
      color: #4f46e5;
      font-weight: 500;
    }

    /* Navbar */
    .navbar {
      background: #fff;
      padding: 10px 20px;
      border-bottom: 1px solid #eee;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    /* Card */
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* Buttons */
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
      background-color: #facc15;
      color: #111;
    }
    .btn-edit:hover {
      background-color: #eab308;
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

    /* Offcanvas customization */
    .offcanvas {
      background: #f8f9fc;
      border-radius: 0 16px 16px 0;
      box-shadow: 2px 0 12px rgba(0,0,0,0.1);
      width: 230px !important;
    }
    .offcanvas .offcanvas-header {
      border-bottom: 1px solid #eee;
    }
    .offcanvas h5 {
      font-weight: 600;
    }
  </style>
</head>
<body>

<!-- Navbar (mobile only) -->
<nav class="navbar d-md-none d-flex justify-content-between align-items-center">
  <h5 class="mb-0">Inventory</h5>
  <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
    ☰
  </button>
</nav>

<div class="d-flex">
  <!-- Sidebar (desktop) -->
  <div class="sidebar d-none d-md-block">
    <h4 class="mb-4">Inventory</h4>
    <h6>Menu</h6>
    <a href="{{ route('inventory.dashboard') }}">Dashboard</a>
    <a href="{{ route('inventory.supply') }}">Supply</a>
    <a href="{{ route('inventory.transaction') }}">Transaction</a>
    <a href="{{ route('inventory.warehouse') }}" class="active">Warehouse</a>
    <a href="{{ route('inventory.category') }}">Category</a>
    <a href="{{ route('inventory.items') }}">Items</a>
    <a href="{{ route('inventory.log') }}">Log</a>

    <h6>Others</h6>
    <a href="{{ route('inventory.account') }}">Account</a>
    <a href="{{ route('inventory.help') }}">Help</a>
  </div>

  <!-- Offcanvas Sidebar (mobile) -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Inventory</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <h6>Menu</h6>
      <a href="{{ route('inventory.dashboard') }}" class="d-block mb-2">Dashboard</a>
      <a href="{{ route('inventory.supply') }}" class="d-block mb-2">Supply</a>
      <a href="{{ route('inventory.transaction') }}" class="d-block mb-2">Transaction</a>
      <a href="{{ route('inventory.warehouse') }}" class="d-block mb-2 active">Warehouse</a>
      <a href="{{ route('inventory.category') }}" class="d-block mb-2">Category</a>
      <a href="{{ route('inventory.items') }}" class="d-block mb-2">Items</a>
      <a href="{{ route('inventory.log') }}" class="d-block mb-2">Log</a>

      <h6>Others</h6>
      <a href="{{ route('inventory.account') }}" class="d-block mb-2">Account</a>
      <a href="{{ route('inventory.help') }}" class="d-block mb-2">Help</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex-grow-1">
    <div class="container-fluid p-4">
      <h5 class="mb-4">Warehouse</h5>

      <div class="card p-3">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Accumulated Items</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Gudang 1</td>
                <td>Alat alat elektronik</td>
                <td>534523</td>
                <td class="text-center">
                  <a href="#" class="btn btn-sm btn-custom btn-edit me-2">Edit</a>
                  <a href="#" class="btn btn-sm btn-custom btn-delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Gudang 2</td>
                <td>Alat biasa</td>
                <td>534523</td>
                <td class="text-center">
                  <a href="#" class="btn btn-sm btn-custom btn-edit me-2">Edit</a>
                  <a href="#" class="btn btn-sm btn-custom btn-delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Gudang 3</td>
                <td>Baju, celana, dsb</td>
                <td>534523</td>
                <td class="text-center">
                  <a href="#" class="btn btn-sm btn-custom btn-edit me-2">Edit</a>
                  <a href="#" class="btn btn-sm btn-custom btn-delete">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-4">
        <a href="#" class="btn btn-custom btn-add">+ Add Warehouse</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
