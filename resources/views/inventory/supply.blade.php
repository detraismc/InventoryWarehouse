<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supply - Inventory</title>
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
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .table thead {
      background-color: #eef2ff;
    }
    .table th {
      color: #4f46e5;
    }
  </style>
</head>
<body>

<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="mb-4">Inventory</h4>
    <h6>Menu</h6>
    <a href="dashboard.html">Dashboard</a>
    <a href="supply.html" class="active">Supply</a>
    <a href="warehouse.html">Warehouse</a>
    <a href="category.html">Category</a>
    <a href="items.html">Items</a>
    <a href="transaction.html">Transaction</a>

    <h6>Others</h6>
    <a href="#">Accounts</a>
    <a href="#">Help</a>
  </div>

  <!-- Main Content -->
  <div class="flex-grow-1">
    <div class="container-fluid p-4">
      <h5 class="mb-4">Supply Overview</h5>

      <!-- Top Summary Cards -->
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card p-3">
            <span class="stats-label">Total Suppliers</span>
            <span class="stats-number">12</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-3">
            <span class="stats-label">Pending Orders</span>
            <span class="stats-number">5</span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-3">
            <span class="stats-label">Low Stock Alerts</span>
            <span class="stats-number text-danger">3</span>
          </div>
        </div>
      </div>

      <!-- Supply Table -->
      <div class="card p-3">
        <h6 class="mb-3">Supplies List</h6>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Supplier Name</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Expected Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>ABC Foods</td>
                <td>Rice 25kg</td>
                <td>50</td>
                <td><span class="badge bg-success">Delivered</span></td>
                <td>2025-09-20</td>
              </tr>
              <tr>
                <td>2</td>
                <td>FreshMart</td>
                <td>Cooking Oil</td>
                <td>30</td>
                <td><span class="badge bg-warning text-dark">Pending</span></td>
                <td>2025-09-28</td>
              </tr>
              <tr>
                <td>3</td>
                <td>FarmCo</td>
                <td>Eggs (crate)</td>
                <td>20</td>
                <td><span class="badge bg-danger">Delayed</span></td>
                <td>2025-09-25</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
