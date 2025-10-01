<div class="modal fade" id="itemDetailsModal{{ $item->id }}" tabindex="-1"
    aria-labelledby="itemDetailsLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm rounded-3">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold" id="transportSupplyModalLabel">Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Name</span>
                        <span>{{ $item->name }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-start">
                        <span class="text-muted">Description</span>
                        <span class="ms-2 text-wrap" style="max-width: 70%;">{{ $item->description }}</span>
                    </li>

                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Category</span>
                        <span>{{ $item->category->name ?? '-' }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Warehouse</span>
                        <span>{{ $item->warehouse->name ?? '-' }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Quantity</span>
                        <span>{{ $item->quantity ?? '-' }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">SKU</span>
                        <span>{{ $item->sku ?? '-' }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Reorder Level</span>
                        <span>{{ $item->reorder_level ?? '-' }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Supply Cost</span>
                        <span class="fw-bold text-success">
                            Rp{{ number_format($item->standard_supply_cost, 0, ',', '.') }}
                        </span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Sell Price</span>
                        <span class="fw-bold text-danger">
                            Rp{{ number_format($item->standard_sell_cost, 0, ',', '.') }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
