<div class="sidebar">
    <h4 class="mb-4">Inventory</h4>

    <h6>Menu</h6>
    <a href="{{ route('inventory.dashboard') }}"
        class="{{ request()->routeIs('inventory.dashboard') ? 'active' : '' }}">Dashboard</a>

    <a href="{{ route('inventory.supply') }}"
        class="{{ request()->routeIs('inventory.supply') ? 'active' : '' }}">Supply</a>

    <a href="{{ route('inventory.transaction') }}"
        class="{{ request()->routeIs('inventory.transaction') ? 'active' : '' }}">Transaction</a>

    <a href="{{ route('inventory.warehouse') }}"
        class="{{ request()->routeIs('inventory.warehouse') ? 'active' : '' }}">Warehouse</a>

    <a href="{{ route('inventory.category') }}"
        class="{{ request()->routeIs('inventory.category') ? 'active' : '' }}">Category</a>

    <a href="{{ route('inventory.item') }}"
        class="{{ request()->routeIs('inventory.item') ? 'active' : '' }}">Item</a>

    <a href="{{ route('inventory.log') }}" class="{{ request()->routeIs('inventory.log') ? 'active' : '' }}">Log</a>

    <h6>Others</h6>
    <a href="{{ route('inventory.account') }}"
        class="{{ request()->routeIs('inventory.account') ? 'active' : '' }}">Account</a>

    <a href="{{ route('inventory.help') }}"
        class="{{ request()->routeIs('inventory.help') ? 'active' : '' }}">Help</a>
</div>
