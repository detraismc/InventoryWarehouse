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
    .sidebar a.active, .sidebar a:hover {
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
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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
  </style>
</head>
<body>

<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="mb-4">Inventory</h4>
    <h6>Menu</h6>
    <a href="{{ route('inventory.dashboard') }}">Dashboard</a>
    <a href="{{ route('inventory.supply') }}">Supply</a>
    <a href="{{ route('inventory.transaction') }}">Transaction</a>
    <a href="{{ route('inventory.warehouse') }}">Warehouse</a>
    <a href="{{ route('inventory.category') }}" class="active">Category</a>
    <a href="{{ route('inventory.items') }}">Items</a>
    <a href="{{ route('inventory.log') }}">Log</a>

    <h6>Others</h6>
    <a href="{{ route('inventory.account') }}">Account</a>
    <a href="{{ route('inventory.help') }}">Help</a>
  </div>

  <!-- Main Content -->
  <div class="flex-grow-1">

    <!-- Dashboard Content -->
    <div class="container-fluid p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Category</h5>
      </div>

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
              <tr>
                <td>1</td>
                <td>Electronics</td>
                <td>Alat alat elektronik</td>
                <td class="text-center">
                  <a href="#" class="btn btn-sm btn-custom btn-edit me-2">Edit</a>
                  <a href="#" class="btn btn-sm btn-custom btn-delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Tools</td>
                <td>Alat biasa</td>
                <td class="text-center">
                  <a href="#" class="btn btn-sm btn-custom btn-edit me-2">Edit</a>
                  <a href="#" class="btn btn-sm btn-custom btn-delete">Delete</a>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Clothes</td>
                <td>Baju, celana, dsb</td>
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
        <a href="#" class="btn btn-custom btn-add">+ Add Category</a>
      </div>

    </div>
  </div>
</div>

</body>
</html>
