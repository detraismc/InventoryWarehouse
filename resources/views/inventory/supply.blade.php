@extends('layouts.inventory')

@section('title', 'Supply Overview')

@section('content')


    <div class="container py-1">
        <div class="card">
            <!-- Warehouse Tabs as Card Header -->
            <div class="card-header border-0 pb-1.2">
                <ul class="nav nav-tabs card-header-tabs">
                    @foreach ($warehouseList as $w)
                        <li class="nav-item">
                            <a href="{{ route('inventory.supply.show', $w->id) }}"
                                class="nav-link {{ isset($warehouse) && $warehouse->id == $w->id ? 'active' : '' }}">
                                {{ $w->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>


            </div>

            <!-- Tab Contents -->
            <div class="card-body">



                <div class="mb-4">
                    <span class="d-block text-muted fst-italic mb-2">
                        {{ $warehouse->description ?? 'No description available' }}
                    </span>
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="bi bi-geo-alt me-1 text-danger"></i>
                        {{ $warehouse->address }}
                    </span>
                </div>









                <h5 class="mb-1.5">Actions:</h5>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <!-- Add Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#addSupplyModal">
                        Add Supply
                    </button>

                    <!-- Sell Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#sellSupplyModal">
                        Sell Supply
                    </button>

                    <!-- Transport Supply -->
                    <button class="btn btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#transportSupplyModal">
                        Transport Supply
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Reorder Level</th>
                                <th style="width: 80px;" class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($itemList as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->reorder_level }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-custom btn-edit me-2"
                                            data-bs-toggle="modal" data-bs-target="#itemDetailsModal{{ $item->id }}">
                                            Details
                                        </button>
                                    </td>
                                </tr>
                                @include('partials.modal_supplydetail')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>




    @include('partials.modal_addsupply')
    @include('partials.modal_sellsupply')
    @include('partials.modal_transportsupply')






















    <script>
        document.addEventListener("input", function(e) {
            if (e.target.type === "number" && e.target.name.includes("[quantity]")) {
                if (e.target.value < 1) e.target.value = 1;
            }
        });


        document.addEventListener("DOMContentLoaded", function() {

            // Find all modals that need their forms handled
            const managedModals = document.querySelectorAll(".modal-form-handler");

            managedModals.forEach(modal => {
                const container = modal.querySelector(
                    ".items-container");


                // --- DYNAMIC ROW LOGIC (ONLY APPLIES IF A CONTAINER EXISTS) ---
                if (container) {
                    const addBtn = modal.querySelector(".add-item-btn");
                    let index = 1;

                    // Function to show/hide remove buttons
                    const updateRemoveButtons = () => {
                        const rows = container.querySelectorAll(".item-row");
                        rows.forEach(row => {
                            const removeBtn = row.querySelector(".remove-item-btn");
                            removeBtn.classList.toggle("d-none", rows.length <= 1);
                        });
                    };

                    // Add new item row
                    addBtn.addEventListener("click", function() {
                        let newRow = container.firstElementChild.cloneNode(true);

                        newRow.querySelectorAll("input, select").forEach(el => el.value = "");

                        const newQuantityInput = newRow.querySelector("input[name*='[quantity]']");
                        if (newQuantityInput) newQuantityInput.value = "1";

                        newRow.querySelectorAll("[name]").forEach(el => {
                            el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
                        });

                        container.appendChild(newRow);
                        index++;
                        updateRemoveButtons();
                    });

                    // Event delegation for remove and select changes
                    container.addEventListener("click", function(e) {
                        if (e.target.classList.contains("remove-item-btn")) {
                            e.target.closest(".item-row").remove();
                            updateRemoveButtons();
                        }
                    });

                    container.addEventListener("change", function(e) {
                        if (e.target.tagName === "SELECT") {
                            const selectedOption = e.target.options[e.target.selectedIndex];
                            const value = selectedOption.getAttribute("data-value");
                            const row = e.target.closest(".item-row");
                            const valueInput = row.querySelector(
                                "input[name*='[cost]'], input[name*='[revenue]']");

                            if (valueInput) {
                                valueInput.value = value ? new Intl.NumberFormat("id-ID").format(
                                    value) : "";
                            }
                        }
                    });

                    // Set initial state
                    updateRemoveButtons();
                }
            });
        });
    </script>


@endsection
