<div class="modal fade modal-form-handler" id="transportSupplyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-sm rounded-3">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Transport Supply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('inventory.supply.store') }}" method="POST">
                @csrf
                <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">
                <input type="hidden" name="transaction_type" value="transport">

                <div class="modal-body">
                    <div class="items-container">
                        <div class="item-row row g-2 mb-2">
                            <div class="col-md-7">
                                <label class="form-label small">Item</label>
                                <select class="form-select" name="transaction_item[0][id]" required>
                                    <option value="">-- Select Item --</option>
                                    @foreach ($itemList as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Quantity</label>
                                <input type="number" class="form-control" name="transaction_item[0][quantity]"
                                    placeholder="Qty" value="1" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button"
                                    class="btn btn-danger btn-sm remove-item-btn d-none">&times;</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success btn-sm mb-5 add-item-btn">+ Add Item</button>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Destination Warehouse</label>
                            <select class="form-select" name="warehouse_target" required>
                                <option value="">-- Select Warehouse --</option>
                                @foreach ($warehouseList as $w)
                                    @if ($w->id !== $warehouse->id)
                                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Transport Fee</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-format" name="transport_fee"
                                    placeholder="Enter Fee for Shipment">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Enter Notes"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom btn-add btn-sm">Create Transport</button>
                </div>
            </form>
        </div>
    </div>
</div>
