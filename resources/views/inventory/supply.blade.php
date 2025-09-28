@extends('layouts.inventory')

@section('title', 'Supply Overview')

@section('content')


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

@endsection
