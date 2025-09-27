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
    .stats-number {
      font-size: 22px;
      font-weight: 600;
      color: #111;
    }
    .stats-label {
      color: #777;
      font-size: 14px;
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
    <a href="{{ route('inventory.category') }}">Category</a>
    <a href="{{ route('inventory.items') }}">Items</a>
    <a href="{{ route('inventory.log') }}">Log</a>

    <h6>Others</h6>
    <a href="{{ route('inventory.account') }}">Account</a>
    <a href="{{ route('inventory.help') }}" class="active">Help</a>
  </div>

  <!-- Main Content -->
  <div class="flex-grow-1">


    <!-- Dashboard Content -->
    <div class="container-fluid p-4">
      <h5 class="mb-4">Help</h5>







    </div>
  </div>
</div>

</body>
</html>
